
<div class="units-row end">
    <div class="unit-centered unit-80 cuerpocentral">
    	<div class="slider-wrapper theme-default">
            <!--<img src="<?=$includes_dir?>images/promocion.png" class="imgpromo2" alt="" > -->
            <div id="slider" class="nivoSlider">
                <?php
                $kont_slide=0;
                foreach($images as $key){
                    $kont_slide++;
                    if ($key->enlace!=""){ 
                        echo '<a href="';
                        if(strrpos($key->enlace,"www")!==false||strrpos($key->enlace,"http://")!==false){
                            if(strrpos($key->enlace,"http://")===false)
                                echo 'http://';
                            echo $key->enlace; 
                        }
                        else echo base_url($key->enlace);
                        echo '">';
                    }
                    ?>
        			<img alt="slide-<?php echo $kont_slide; ?>" src="<?php echo $includes_dir; ?>images/slider/<?=$key->id?>.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 1170px; width: 100%; z-index: 10; display: block;" slidesjs-index="0">
                    <?php 
                    if ($key->enlace!="") 
                        echo '</a>';    
                }
                ?>
    		</div>
    	</div>

        <script>
        $(window).load(function() {
            $('#slider').nivoSlider({effect: 'fade',animSpeed: 1});
        });
        </script>
    </div>
</div>
