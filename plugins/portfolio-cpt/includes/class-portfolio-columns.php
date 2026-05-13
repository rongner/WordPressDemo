<?php
defined( 'ABSPATH' ) || exit;

/**
 * Custom admin list-table columns for the Portfolio CPT:
 *   thumbnail | title (default) | project type | client | year | date (default)
 */
class Portfolio_Columns {

	public function init() {
		add_filter( 'manage_portfolio_posts_columns',       [ $this, 'define_columns' ] );
		add_action( 'manage_portfolio_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
		add_filter( 'manage_edit-portfolio_sortable_columns', [ $this, 'sortable_columns' ] );
		add_action( 'pre_get_posts',                        [ $this, 'handle_sort' ] );
		add_action( 'admin_head',                           [ $this, 'column_styles' ] );
	}

	public function define_columns( $columns ) {
		$new = [];

		// Insert thumbnail right after checkbox (cb)
		foreach ( $columns as $key => $label ) {
			$new[ $key ] = $label;
			if ( $key === 'cb' ) {
				$new['pcpt_thumb'] = __( '', 'portfolio-cpt' ); // no header label — icon only
			}
		}

		$new['pcpt_type']   = __( 'Project Type', 'portfolio-cpt' );
		$new['pcpt_client'] = __( 'Client',        'portfolio-cpt' );
		$new['pcpt_year']   = __( 'Year',           'portfolio-cpt' );

		return $new;
	}

	public function render_column( $column, $post_id ) {
		switch ( $column ) {
			case 'pcpt_thumb':
				$thumb = get_the_post_thumbnail( $post_id, [ 48, 48 ] );
				if ( $thumb ) {
					printf( '<a href="%s">%s</a>', esc_url( get_edit_post_link( $post_id ) ), $thumb );
				} else {
					echo '<span class="pcpt-no-thumb dashicons dashicons-format-image"></span>';
				}
				break;

			case 'pcpt_type':
				$terms = get_the_terms( $post_id, 'portfolio_type' );
				if ( $terms && ! is_wp_error( $terms ) ) {
					$links = array_map( function( $term ) {
						$url = add_query_arg( [
							'post_type'     => 'portfolio',
							'portfolio_type' => $term->slug,
						], admin_url( 'edit.php' ) );
						return sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $term->name ) );
					}, $terms );
					echo implode( ', ', $links );
				} else {
					echo '<span aria-hidden="true">—</span>';
				}
				break;

			case 'pcpt_client':
				$client = get_post_meta( $post_id, '_portfolio_client', true );
				echo $client ? esc_html( $client ) : '<span aria-hidden="true">—</span>';
				break;

			case 'pcpt_year':
				$year = get_post_meta( $post_id, '_portfolio_year', true );
				echo $year ? esc_html( $year ) : '<span aria-hidden="true">—</span>';
				break;
		}
	}

	public function sortable_columns( $columns ) {
		$columns['pcpt_year']   = 'pcpt_year';
		$columns['pcpt_client'] = 'pcpt_client';
		return $columns;
	}

	public function handle_sort( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() ) return;
		if ( $query->get( 'post_type' ) !== 'portfolio' ) return;

		$orderby = $query->get( 'orderby' );

		if ( $orderby === 'pcpt_year' ) {
			$query->set( 'meta_key', '_portfolio_year' );
			$query->set( 'orderby', 'meta_value_num' );
		} elseif ( $orderby === 'pcpt_client' ) {
			$query->set( 'meta_key', '_portfolio_client' );
			$query->set( 'orderby', 'meta_value' );
		}
	}

	public function column_styles() {
		global $post_type;
		if ( $post_type !== 'portfolio' ) return;
		?>
		<style>
			.column-pcpt_thumb { width: 58px; }
			.column-pcpt_thumb img { border-radius: 3px; display: block; }
			.column-pcpt_thumb .pcpt-no-thumb { color: #bbb; font-size: 2rem; display: block; }
			.column-pcpt_year  { width: 60px; }
			.column-pcpt_client{ width: 140px; }
			.column-pcpt_type  { width: 140px; }
		</style>
		<?php
	}
}
