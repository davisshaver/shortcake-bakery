<?php

class Test_YouTube_Shortcode extends WP_UnitTestCase {

	public function test_post_display() {
		$post_id = $this->factory->post->create( array( 'post_content' => '[youtube url="https://www.youtube.com/watch?v=hDlpVFDmXrc"]' ) );
		$post = get_post( $post_id );
		$this->assertContains( '<iframe class="shortcake-bakery-responsive" width="640" height="360" src="https://youtube.com/embed/hDlpVFDmXrc" frameborder="0"></iframe>', apply_filters( 'the_content', $post->post_content ) );
	}

	public function test_embed_reversal() {
		$old_content = <<<EOT
		apples before

		<iframe width="640" height="360" src="https://www.youtube.com/embed/hDlpVFDmXrc" frameborder="0" allowfullscreen></iframe>

		bananas after
EOT;

		$expected_content = <<<EOT
		apples before

		[youtube url="https://www.youtube.com/watch?v=hDlpVFDmXrc"]

		bananas after
EOT;

		$transformed_content = wp_filter_post_kses( $old_content );
		$transformed_content = str_replace( '\"', '"', $transformed_content ); // Kses slashes the data
		$this->assertEquals( $expected_content, $transformed_content );
	}

}
