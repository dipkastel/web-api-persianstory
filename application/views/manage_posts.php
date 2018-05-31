<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
include('php/jdf.php');

?>


<div class="container">
        <div class="bodyBox">
            <div class="titleBox">
                <span>مدیریت سایت » مدیریت پست ها » پست ها</span>
            </div>
                
                <?php if($sucs != "") { ?>
            <div class="alert alert-success">
              <?php echo $sucs; ?>
            </div>
            <?php } ?>

                <table class="table table-striped">
    <thead>
      <tr>
        
        
        <th>نام پست</th>
        <th>دسته بندی</th>
        <th>تاریخ ارسال</th>
        <th>وضعیت</th>
        <th>مدیریت</th>
      </tr>
    </thead>
    <tbody>
    <?php
              if($posts != null ) {
$i = 0;
                foreach ($posts as $post) {
               $i++;
                
                echo "<tr><td>".$post->name."</td>";
                echo "<td>".$this->model_admin->get_dataCat('tg_cats','id',$post->cat,'name')."</td>";
                echo "<td>".jdate("Y-m-d h:i a",$post->datetime)."</td>";
                echo "<td>".show_status($this->model_admin->get_dataSingle('tg_dastan','status',$post->status,'status'))."</td>";
                echo '<td><a href="'.base_url('tg-admin/addPost/editPost?editPostId='.$post->id).'">ویرایش</a> / <a data-toggle="modal" data-target="#myModal_'.$i.'">حذف</a></td></tr>';
?>
<!-- Modal -->
<div id="myModal_<?=$i;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">حذف قصه</h4>
      </div>
      <div class="modal-body">
        <p>آیا از حذف قصه <?=$post->name;?> مطمئن هستید ؟</p>
      </div>
      <div class="modal-footer">
       <a href="<?php echo base_url('tg-admin/managePosts/RemovePost?id='.$post->id); ?>">بله</a>
        <button type="button" class="btn btn-default" data-dismiss="modal" >خیر</button>
      </div>
    </div>

<?php
            }
        }

            function show_status($val) {
                switch ($val) {
                    case '1':
                       $ret = "منشتر شده";
                        break;
                     case '2':
                     $ret = "پیش نویس";
                     break;
                    default:
                        $ret = "پیش نویس";
                        break;
                }
                return $ret;
               
            }
   


       

        
        ?>
    </tbody>
  </table>
  
<?php echo $pagination; ?>
        </div>
    </div>



  </div>