<?php 
/**
 * Components/Slider
 *
 * @package ctwp
 */
?>
<?php
  $sliders = get_sub_field('content');
  if(empty($sliders))
    return;
?>
<div class="carousel"
  data-flickity='{
            "cellAlign": "left",
            "imagesLoaded": true,
            "lazyLoad": 1,
            "freeScroll": false,
            "wrapAround": true,
            "autoPlay": 6000,
            "pauseAutoPlayOnHover" : true,
            "prevNextButtons": true,
            "contain" : true,
            "adaptiveHeight" : true,
            "dragThreshold" : 10,
            "percentPosition": true,
            "pageDots": true,
            "rightToLeft": false,
            "draggable": true,
            "selectedAttraction": 0.1,
            "parallax" : 0,
            "friction": 0.6        }'>
            <?php foreach($sliders as $key => $slider): ?>
              <?php 
                $background = isset($slider['background']) ? $slider['background'] : '';
                $title = isset($slider['title']) ? esc_html( $slider['title'] ) : '';
                $description = isset($slider['description']) ? esc_html( $slider['description'] ) : '';
                $button = isset($slider['button']) ? esc_html( $slider['button'] ) : '';
                $link = isset($slider['link']) ? esc_html( $slider['link'] ) : '';
                $tag = 'h2';
                $textAlign = 'left';
                ?>
  <div class="carousel-cell">
    <div class="carousel-inner">
      <a href="<?php echo esc_url( $link ) ?>">
      <div class="container">
        <div class="background">
          <?php ctwp_heading($tag, $title, $textAlign) ?>
          <?php ctwp_description($description, $textAlign); ?>
        </div>
      </div>
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>