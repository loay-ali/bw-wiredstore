<?php
/**
 * The Footer Template
 *
 * @package bw-wiredstore
 */
?>
		</section>
		
		<section class = 'bw-window' style = 'display:none;'>
			
			<div class = 'layout'></div>
			
			<header class = 'bw-window-header'>
				<h2>Title</h2>
				<button
					class = 'bw-close-window'
					type = 'button'>
					<i class = 'bwi bwi-cross'></i>
				</button>
			</header>
			
			<section class = 'bw-window-container'>
			
				<section class = 'bw-window-content'>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Proin a urna ligula. Nulla facilisi. Praesent in pretium augue.
					Aenean justo nisi, ullamcorper id ligula sed, efficitur eleifend nunc.
					Suspendisse convallis odio sit amet urna dictum pulvinar at ut turpis.
					Nulla varius nisi vel nulla venenatis hendrerit.
					Duis lacinia cursus ante, at dictum tortor euismod eu.
					Maecenas nisi enim, facilisis ac finibus vel, ullamcorper vel augue.
					<hr />
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Aenean sit amet convallis ex, in sollicitudin mi.
					Morbi id nulla vel diam fermentum blandit a accumsan sapien.
					Suspendisse fringilla ullamcorper malesuada. Ut malesuada enim ut nisi pellentesque fringilla.
					<hr />
					Mauris mollis bibendum aliquam. Phasellus dictum ante a ligula rhoncus, bibendum tempor diam rutrum.
					Vivamus ullamcorper posuere lorem a euismod. Proin sollicitudin nec velit non convallis. Nullam sed imperdiet ante.
					Curabitur ullamcorper vulputate est venenatis accumsan. Nunc sagittis odio neque, auctor pharetra quam convallis et.
					Suspendisse non urna scelerisque, aliquam felis et, elementum massa. Nullam facilisis, risus ut convallis varius, urna leo ullamcorper tellus, sit amet tincidunt urna lacus in velit.
					Nunc ac maximus enim.
				</section>
				
				<footer class = 'bw-window-footer'>
					
					<button>Button 1</button>
					
					<button>Button 2</button>
					
				</footer>
			
			</section>
			
		</section>
		
		<button 
			title = '<?php _e("Go To The Top Of The Page",'bw');?>' 
			id = 'going-up' 
			style = 'display:none;'>
			<i class = 'fas fa-angle-up fa-2x'></i>
		</button>
		
		<footer id = "main-footer">
			<section id = 'footer-widgets'>
				<?php
					for($w = 1;$w <= 3;$w++) {
						echo "<div id = 'footer-widget-$w'>";
						if(is_active_sidebar("footer-" . $w)) {
							dynamic_sidebar("footer-" . $w);
						}
						echo "</div>";
					}
				?>
			</section>
			
			<p id = 'rights-text'>
				<?php _e("All Rights Reserved ".Date("Y"),'bw'); ?>
			</p>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>