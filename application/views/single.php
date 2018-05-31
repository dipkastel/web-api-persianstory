<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>	
	<div class="container">
		



		<div class="bodyBox">
			<?php foreach ($postinfo as $item) :
			$rate = round($this->model_home->calc_rate($item['id']),1);
			
			 ?>
			
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-lg-12">
					
						<div class="itemSingle">
						<div class="col-sm-6 col-md-3 col-lg-3">
							<div class="cover">
								<img src="<?php echo $this->config->item('upload_url').$item['pic'];?>">
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<ul class="list">
								<li><div class="namePost"><i class="glyphicon glyphicon-chevron-left"></i><span>نام قصه : </span> <h1><?=$item['name'];?></h1></div></li>
								<li><i class="glyphicon glyphicon-user"></i>نام قصه گو : <?=$item['teller'];?></li>
								<li><i class="glyphicon glyphicon-star"></i>امتیاز : <?php echo $rate; ?> / 5 از <?php echo $votes;?> امتیاز دهنده </li>
								<li><i class="glyphicon glyphicon-eye-open"></i> بازدید ها : <?=$item['views'];?></li>
								<li><i class="glyphicon glyphicon-usd"></i>قیمت : <?php if($item['price'] == 0 || $item['price'] == "") echo "رایگان"; else echo $item['price']." سکه"; ?></li>
								<li class="desc"><i class="glyphicon glyphicon-info-sign"></i>خلاصه داستان : 
								
								<?=$item['content'];?>


													


								</li>
							</ul>
						</div>
						<div class="col-sm-12 col-md-3 col-lg-3">
							<div class="controller">
								
								<button type="button" id="dl" class="btns btn btn-success <?php if($item['sound'] == "") echo "disabled"; ?>">دریافت فایل صوتی</button>
								<button type="button" class="btns btn btn-info" data-toggle="modal" data-target="#myModal">امتیاز به قصه</button>
								<button type="button" class="btns btn btn-warning">ارسال به دوست</button>
								<div class="qrcode"><center><img src="https://api.qrserver.com/v1/create-qr-code/?size=95x95&data=<?php echo base_url('/p/'.$item['id']); ?>%26ref=web_QR" height="95" width="95"/></center>
								<p><center>برای مشاهده این قصه در گوشی کد را اسکن کنید . <a href="">راهنمای استفاده از qr code</a></center></p></div>
							</div>
							</div>
						</div>
							<div class="clearfix"></div>
							<?php if($item['sound'] != "") { ?><div class="contentPost">
								<audio src="<?= $this->config->item('upload_url').$item['sound'];?>" controls style="width:100%;">	
									<embed 
										src="<?=$this->config->item('upload_url').$item['sound'];?>"
										
										height="90"
										loop="false"
										autostart="false">
								</audio>
							</div>
							<?php } ?>
							<div class="contentPost">
								<p><?=$item['description'];?></p>
							</div>
						</div>
					
				</div>


				<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">امتیاز به قصه <?=$item['name'];?></h4>
      </div>
      <div class="modal-body">
        <p>به این قصه از 1 تا 5 امتیاز دهید</p>
		 <fieldset class="rating">
                        <input class="stars" type="radio" id="star5" name="rating" value="5" <?php if($rate > 4) echo "checked='checked'"; ?>/>
                        <label class = "full" for="star5"></label>
                        <input class="stars" type="radio" id="star4" name="rating" value="4" <?php if($rate > 3 && $rate < 5) echo "checked='checked'"; ?>/>
                        <label class = "full" for="star4"></label>
                        <input class="stars" type="radio" id="star3" name="rating" value="3" <?php if($rate > 2 && $rate < 4) echo "checked='checked'"; ?>/>
                        <label class = "full" for="star3"></label>
                        <input class="stars" type="radio" id="star2" name="rating" value="2" <?php if($rate > 1 && $rate < 3) echo "checked='checked'"; ?> />
                        <label class = "full" for="star2"></label>
                        <input class="stars" type="radio" id="star1" name="rating" value="1" <?php if($rate > 0 && $rate < 2) echo "checked='checked'"; ?> />
                        <label class = "full" for="star1"></label>


 
                    </fieldset>	
                    <div id="feedback"></div>
                    <div class="clearfix"></div>
      </div>
      
    </div>

  </div>
</div>
		<?php endforeach;?>
		</div>







		<div class="clearfix"></div>
		<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js');?>"></script>
		<script>
						$(document).ready(function() { 
							<?php
							$id=$this->uri->segment(2); 
							 if($item['sound'] != "") { ?>
							$("#dl").click(function () {
								document.location.href = "<?= $this->config->item('upload_url').$item['sound'];?>";
							});	
							<?php }?>
                            $(".stars").click(function () {
                           
                                $.post('<?=$id;?>/addRate/',{rate:$(this).val()},function(d){
                                    if(d>0)
                                    var label = $("label[for='" + $(this).attr('id') + "']");
                                
                                $("#myModal").modal('toggle');
                                
                                });
                                $(this).attr("checked");
                            });
                        });
		</script>
{elapsed_time}
		</div>
		
		

