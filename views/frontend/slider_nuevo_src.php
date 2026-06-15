<div id="slider-portada" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ul class="carousel-indicators">
        <?php
        $kont_slide=0;
        $active=' class="active" ';
        foreach($images as $key){
            echo '<li data-target="#slider-portada" data-slide-to="'.$kont_slide.'" '.$active.' ></li>';
            $kont_slide++;
            $active='';
        }
        ?>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <?php
        $kont_slide=0;
        $active='active';
        foreach($images as $key){
            $kont_slide++;
            $txt_alt='slide-'.$kont_slide;
            if ($key->titulo!='NUEVA')
                $txt_alt=$key->titulo.'-'.$kont_slide;
            
            echo '<div class="carousel-item '.$active.' ">';
            echo '<picture>';
            //echo '<source srcset="'.$key->src.'/'.$key->id.'.webp" type="image/webp">';
            echo '<source srcset="'.$key->src.'" type="image/jpeg">';
            echo '<img src="'.$key->src.'" style="width:100%" alt="'.$txt_alt.'" height="'.$key->height.'" />';
            echo '</picture>';
            echo '</div>';
            $active='';
        }
        /*
       <div class="carousel-item active">
            <img src="/includes/images/slider/214.jpg" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img src="/includes/images/slider/213.jpg" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img src="/includes/images/slider/212.jpg" alt="Los Angeles">
        </div>
        */
        ?>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#slider-portada" data-slide="prev" aria-label="Imagen anterior">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#slider-portada" data-slide="next"  aria-label="Siguiente imagen">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
