<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>	
	<div class="container">
		<div class="bodyBox">
			<h3><?php echo $title;?></h3>
			
			<div class="clearfix"></div>
			<div class="row">
			
			<?php 
			if($posts != null ) {
			foreach ($posts as $post): 
			$rate = $this->model_home->calc_rate($post->id);
			?>
				<div class="col-md-6 col-lg-6">
					<a href="<?php echo base_url('/p/'.$post->id); ?>">
						<div class="item">
							<div class="cover">
								<img src="<?php echo $this->config->item('upload_url').$post->pic; ?>">
							</div>
							<div class="content">
								<div class="title">
									<h2><?php echo $post->name; ?></h2>
								</div>
								<div class="description">
									<p><?php echo $post->content; ?></p>
								</div><div class="clearfix"></div>
							</div>
							<div class="meta">
									<div class="coin"><span><?php if($post->price == 0 || $post->price == "") echo "رایگان"; else echo $post->price." سکه"; ?></span></div>
									<div class="stars">
										
										<i class="glyphicon glyphicon-star <?php if($rate > 4) echo "activeStar"; ?>"></i>
										<i class="glyphicon glyphicon-star <?php if($rate > 3) echo "activeStar"; ?>"></i>
										<i class="glyphicon glyphicon-star <?php if($rate > 2) echo "activeStar"; ?>"></i>
										<i class="glyphicon glyphicon-star <?php if($rate > 1) echo "activeStar"; ?>"></i>
										<i class="glyphicon glyphicon-star <?php if($rate > 0) echo "activeStar"; ?>"></i>
									</div>
								</div>
						</div>


					</a>
				</div>
				<?php endforeach; }else{echo "پستی یافت نشد";} ?>
				
			</div>
			

			
			
		</div>
		<div class="clearfix"></div>
		<?php echo $pagination; ?>
		<div class="clearfix"></div>
		{elapsed_time}
	
	</div>


	