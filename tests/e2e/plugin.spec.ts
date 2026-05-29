import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe( 'NExT Block Structure Tree', () => {
	test( 'プラグインが有効化されている', async ( { admin, page } ) => {
		await admin.visitAdminPage( 'plugins.php' );
		const pluginRow = page.locator( 'tr[data-slug="next-block-structure-tree"]' );
		await expect( pluginRow ).toHaveClass( /active/ );
	} );

	test( 'ブロックエディタでエディタアセットが読み込まれる', async ( { admin, editor, page } ) => {
		await admin.createNewPost( { postType: 'page', title: 'E2E Test Page' } );
		// Verify the editor script was enqueued by checking the page source
		const handle = await page.evaluateHandle( () => document.documentElement.innerHTML );
		const html = await handle.jsonValue();
		expect( html ).toContain( 'next-bst-editor' );
	} );
} );
