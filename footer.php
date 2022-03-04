				</div>
			</main>

		    <footer>
				<div class="satzspiegel">
			        <?php if(has_template_parts('/template-parts/footer/before/', get_post_type())): ?>
				        <div class="footer-before">
				            <?php get_template_parts('/template-parts/footer/before/', get_post_type()); ?>
				        </div>
			        <?php endif; ?>
			
		            <?php get_template_part('/template-parts/footer/content', get_post_type()); ?>	    
			
			        <?php if(has_template_parts('/template-parts/footer/after/', get_post_type())): ?>
				        <div class="footer-after">
				            <?php get_template_parts('/template-parts/footer/after/', get_post_type()); ?>
				        </div>
			        <?php endif; ?>
				</div>		            
		    </footer>
		    
		</div><!-- /page-wrap -->
		
		<?php wp_footer(); ?>
		
	</body>
</html>