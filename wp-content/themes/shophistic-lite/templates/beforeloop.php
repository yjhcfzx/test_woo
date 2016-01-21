<div id="container" class="container">
	<section id="main" role="main" class="row">
        <div class="content_background">

                <?php if(!is_home){ get_sidebar();}else{ ?>
                    <aside id="sidebar" class="col-md-2">abc</aside>
               <?php } ?>

			<div id="content" class="<?php echo esc_attr( shophistic_lite_content_check_sidebar() ); ?>">
