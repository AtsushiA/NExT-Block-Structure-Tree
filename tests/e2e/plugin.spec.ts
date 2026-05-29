import { test, expect } from '@playwright/test';

test.describe( 'NExT Block Structure Tree', () => {
	test( 'プラグインが有効化されている', async ( { page, baseURL } ) => {
		await page.goto( `${ baseURL }/wp-admin/plugins.php` );
		const pluginRow = page.locator( 'tr[data-slug="next-block-structure-tree"]' );
		await expect( pluginRow ).toHaveClass( /active/ );
	} );

	test( 'ブロックエディタでエディタアセットが読み込まれる', async ( { page, baseURL } ) => {
		await page.goto( `${ baseURL }/wp-admin/post-new.php?post_type=page` );
		// next-bst-editor スクリプトが enqueue されていることを確認.
		const scriptTag = page.locator( 'script[id="next-bst-editor-js"]' );
		await expect( scriptTag ).toBeAttached();
	} );
} );
