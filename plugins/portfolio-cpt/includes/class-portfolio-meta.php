<?php
defined( 'ABSPATH' ) || exit;

/**
 * Meta box for portfolio-specific fields:
 *   _portfolio_url    — live project URL
 *   _portfolio_client — client / company name
 *   _portfolio_year   — year completed (YYYY)
 */
class Portfolio_Meta {

	private const NONCE = 'pcpt_meta_nonce';
	private const META_FIELDS = [ '_portfolio_url', '_portfolio_client', '_portfolio_year' ];

	public function init() {
		add_action( 'add_meta_boxes',  [ $this, 'add_meta_box' ] );
		add_action( 'save_post',       [ $this, 'save' ] );
		add_action( 'rest_api_init',   [ $this, 'register_meta' ] );
	}

	public function add_meta_box() {
		add_meta_box(
			'pcpt_project_details',
			__( 'Project Details', 'portfolio-cpt' ),
			[ $this, 'render' ],
			'portfolio',
			'side',
			'high'
		);
	}

	public function render( $post ) {
		wp_nonce_field( self::NONCE, self::NONCE );

		$url    = get_post_meta( $post->ID, '_portfolio_url',    true );
		$client = get_post_meta( $post->ID, '_portfolio_client', true );
		$year   = get_post_meta( $post->ID, '_portfolio_year',   true );
		?>
		<table class="form-table pcpt-meta-table">
			<tr>
				<th><label for="pcpt_url"><?php esc_html_e( 'Live URL', 'portfolio-cpt' ); ?></label></th>
				<td>
					<input id="pcpt_url" name="_portfolio_url" type="url"
						   class="widefat" value="<?php echo esc_attr( $url ); ?>"
						   placeholder="https://">
				</td>
			</tr>
			<tr>
				<th><label for="pcpt_client"><?php esc_html_e( 'Client', 'portfolio-cpt' ); ?></label></th>
				<td>
					<input id="pcpt_client" name="_portfolio_client" type="text"
						   class="widefat" value="<?php echo esc_attr( $client ); ?>">
				</td>
			</tr>
			<tr>
				<th><label for="pcpt_year"><?php esc_html_e( 'Year', 'portfolio-cpt' ); ?></label></th>
				<td>
					<input id="pcpt_year" name="_portfolio_year" type="number"
						   min="2000" max="<?php echo esc_attr( (int) gmdate( 'Y' ) + 1 ); ?>"
						   style="width:80px;" value="<?php echo esc_attr( $year ); ?>">
				</td>
			</tr>
		</table>
		<?php
	}

	public function save( $post_id ) {
		if (
			! isset( $_POST[ self::NONCE ] ) ||
			! wp_verify_nonce( sanitize_key( $_POST[ self::NONCE ] ), self::NONCE )
		) return;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( get_post_type( $post_id ) !== 'portfolio' ) return;

		$url    = isset( $_POST['_portfolio_url'] )    ? esc_url_raw( wp_unslash( $_POST['_portfolio_url'] ) )            : '';
		$client = isset( $_POST['_portfolio_client'] ) ? sanitize_text_field( wp_unslash( $_POST['_portfolio_client'] ) ) : '';
		$year   = isset( $_POST['_portfolio_year'] )   ? absint( $_POST['_portfolio_year'] )                              : 0;

		update_post_meta( $post_id, '_portfolio_url',    $url );
		update_post_meta( $post_id, '_portfolio_client', $client );
		update_post_meta( $post_id, '_portfolio_year',   $year ?: '' );
	}

	public function register_meta() {
		$shared = [
			'object_subtype' => 'portfolio',
			'single'         => true,
			'show_in_rest'   => true,
		];

		register_post_meta( 'portfolio', '_portfolio_url',    $shared + [ 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ] );
		register_post_meta( 'portfolio', '_portfolio_client', $shared + [ 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ] );
		register_post_meta( 'portfolio', '_portfolio_year',   $shared + [ 'type' => 'integer', 'sanitize_callback' => 'absint' ] );
	}
}
