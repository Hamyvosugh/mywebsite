<?php
/*
Template Name: Bio Page Template
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Start the WordPress loop
while (have_posts()) : the_post();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php the_title(); ?></title>
    <?php wp_head(); // For including necessary WordPress and Elementor Pro styles/scripts ?>
</head>
<body <?php body_class(); ?>>
    <div class="bio-page-content" style="background-color: #fff;">
        <?php
        // Display the Elementor content of the page
        the_content();
        ?>
    </div>

    <?php wp_footer(); // For including necessary WordPress and Elementor Pro scripts ?>
</body>
</html>

<?php
endwhile;
?>