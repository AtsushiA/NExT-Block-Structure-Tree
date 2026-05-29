<?php

namespace NextBST\Tests\Integration;

use WP_UnitTestCase;

class PluginActiveTest extends WP_UnitTestCase {

	public function test_plugin_is_loaded(): void {
		// install-wp-tests.sh 環境では DB に active_plugins が登録されないため
		// is_plugin_active() は false を返す。代わりにプラグイン定数の存在を確認する.
		$this->assertTrue( defined( 'NEXT_BST_VERSION' ) );
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
