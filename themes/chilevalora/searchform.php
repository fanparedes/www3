<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group">
                            <input class="form-control border-right-0 border field" name="s" id="s" type="text" id="search-input" placeholder="<?php esc_attr_e( 'Buscar', 'twentyeleven' ); ?>">
                            <span class="input-group-append">
                                <button style="line-height: 0.5;" class="btn btn-outline-secondary border-left-0 border submit" type="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>">
                                    <i class="far fa-search fa-flip-horizontal"></i>
                                </button>
                              </span>
                        </div>
                    </form>  


  
  