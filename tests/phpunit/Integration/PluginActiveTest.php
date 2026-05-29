<?php

namespace NextBST\Tests\Integration;

use WP_UnitTestCase;

class PluginActiveTest extends WP_UnitTestCase {

	public function test_plugin_is_active(): void {
		$this->assertTrue(
			is_plugin_active( 'next-block-structure-tree/next-block-structure-tree.php' )
		);
	}

	public function test_tree_builder_class_exists(): void {
		$this->assertTrue( class_exists( 'Next_BST_Tree_Builder' ) );
	}

	public function test_generate_post_tree_for_empty_post(): void {
		$post = $this->factory()->post->create_and_get(
			array(
				'post_title'   => 'Test Page',
				'post_content' => '',
				'post_status'  => 'publish',
			)
		);

		$builder = new \Next_BST_Tree_Builder();
		$tree    = $builder->generate_post_tree( $post );

		$this->assertStringContainsString( 'Test Page', $tree );
		$this->assertStringContainsString( '(ブロックなし)', $tree );
	}
}
