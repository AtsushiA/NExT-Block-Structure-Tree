<?php

namespace NextBST\Tests\Unit;

use Next_BST_Tree_Builder;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

class TreeBuilderTest extends TestCase {

	private Next_BST_Tree_Builder $builder;

	protected function setUp(): void {
		parent::setUp();
		require_once dirname( __DIR__, 3 ) . '/includes/class-next-bst-tree-builder.php';
		$this->builder = new Next_BST_Tree_Builder();
	}

	/**
	 * Blocks with no blockName should return the fallback label.
	 * This path requires no WordPress functions, making it safe for unit tests.
	 */
	public function test_get_block_label_returns_unknown_for_empty_name(): void {
		$block = array( 'blockName' => '', 'attrs' => array(), 'innerBlocks' => array() );
		$this->assertSame( '(unknown)', $this->builder->get_block_label( $block ) );
	}

	public function test_get_block_label_returns_unknown_when_blockname_absent(): void {
		$block = array( 'attrs' => array(), 'innerBlocks' => array() );
		$this->assertSame( '(unknown)', $this->builder->get_block_label( $block ) );
	}

	/**
	 * build_tree() last-sibling should use └── connector.
	 * Uses a partial mock to stub get_block_label() and avoid WP dependencies.
	 */
	public function test_build_tree_uses_last_connector_for_last_sibling(): void {
		$mock = $this->getMockBuilder( Next_BST_Tree_Builder::class )
			->onlyMethods( array( 'get_block_label' ) )
			->getMock();
		$mock->method( 'get_block_label' )->willReturn( 'Paragraph' );

		$block = array( 'blockName' => 'core/paragraph', 'attrs' => array(), 'innerBlocks' => array() );
		$lines = $mock->build_tree( $block, '', true );

		$this->assertCount( 1, $lines );
		$this->assertSame( '└── Paragraph', $lines[0] );
	}

	public function test_build_tree_uses_middle_connector_for_non_last_sibling(): void {
		$mock = $this->getMockBuilder( Next_BST_Tree_Builder::class )
			->onlyMethods( array( 'get_block_label' ) )
			->getMock();
		$mock->method( 'get_block_label' )->willReturn( 'Heading' );

		$block = array( 'blockName' => 'core/heading', 'attrs' => array(), 'innerBlocks' => array() );
		$lines = $mock->build_tree( $block, '', false );

		$this->assertSame( '├── Heading', $lines[0] );
	}

	public function test_build_tree_recurses_into_inner_blocks(): void {
		$mock = $this->getMockBuilder( Next_BST_Tree_Builder::class )
			->onlyMethods( array( 'get_block_label' ) )
			->getMock();
		$mock->method( 'get_block_label' )->willReturnOnConsecutiveCalls( 'Group', 'Paragraph' );

		$block = array(
			'blockName'   => 'core/group',
			'attrs'       => array(),
			'innerBlocks' => array(
				array( 'blockName' => 'core/paragraph', 'attrs' => array(), 'innerBlocks' => array() ),
			),
		);
		$lines = $mock->build_tree( $block, '', true );

		$this->assertCount( 2, $lines );
		$this->assertStringContainsString( 'Group', $lines[0] );
		$this->assertStringContainsString( 'Paragraph', $lines[1] );
	}
}
