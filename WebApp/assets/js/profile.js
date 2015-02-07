$(document).ready(function(){

$(".section").niceScroll();
$("#post_modal .content").niceScroll();
$('textarea').autosize();
$("#btn_upload_pic").bootstrapFileInput();
$("#btn_upload_apparel").bootstrapFileInput();

$(".edit_pic").click(function(){
$("#change_profile_modal").show();
});
$("#featured").show();

$("#post_to_timeline").click(function(){
$("#post_modal").show();
});

$(".close_profile_modal").click(function(){
$("#change_profile_modal").hide();
});

$(".close_post_modal").click(function(){
$("#post_modal").hide();
});

$(".tab").click(function(){
$(".tab").removeClass("active_tab");
$(".spot_contents").hide();
$(this).addClass("active_tab");
$("#"+$(this).data('div')).show();
});
function readURL(input,imageID) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+imageID).attr('src', e.target.result);   
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#btn_upload_pic").change(function(){
    readURL(this,'uploaded_img');
});
$("#btn_upload_apparel").change(function(){
    readURL(this,'uploaded_apparel');
});


$("#post_form").submit(function(e){
  e.preventDefault();
  var formData = new FormData($(this)[0]);
  $.ajax({
        url:'post',
        type: 'POST',
        data: formData,
        async: false,
        success: function (response) {
        if(response == 1){
          document.getElementById("post_form").reset();
          $(".file-input-name").text("");
          $("#uploaded_apparel").attr("src","#");
		  $("#post_feedback").html("<span style='margin-right:10px;color:#666;'>Apparel upload successfull</span><img src='/assets/images/valid.png' style='width:25px;'/>");
		setTimeout(function(){
		 $("#post_feedback").html("");
		},3000);
		console.log(data);
        }else if(response == 0){
          document.getElementById("post_form").reset();
		  $(".file-input-name").text("");
          $("#uploaded_apparel").attr("src","#");
		   $("#post_feedback").html("<span style='margin-right:10px;color:#666;'>Apparel upload Failed</span><img src='/assets/images/invalid.png' style='width:25px;'/>");
		   setTimeout(function(){
		 $("#post_feedback").html("");
		},3000);
		console.log(data);
        }
        
        },
        cache: false,
        contentType: false,
        processData: false
    });
});





$("#profile_pic_form").submit(function(e){
e.preventDefault();
var formData = new FormData($(this)[0]);
  $.ajax({
        url:'update_profile_pic',
        type: 'POST',
        data: formData,
        async: false,
        success: function (response) {
        if(response == 1){
          document.getElementById("profile_pic_form").reset();
          $(".file-input-name").text("");
          $("#uploaded_img").attr("src","#");
		  $("#profile_feedback").html("<span style='margin-right:10px;color:#666;'>Profile Pics upload successfull</span><img src='/assets/images/valid.png' style='width:25px;'/>");
		setTimeout(function(){
		 $("#profile_feedback").html("");
		 console.log(data);
		},3000);
        }else if(response == 0){
          document.getElementById("profile_pic_form").reset();
		  $(".file-input-name").text("");
          $("#uploaded_img").attr("src","#");
		   $("#profile_feedback").html("<span style='margin-right:10px;color:#666;'>Profile pics upload Failed</span><img src='/assets/images/invalid.png' style='width:25px;'/>");
		   setTimeout(function(){
		 $("#profile_feedback").html("");
		 console.log(data);
		},3000);
        }
        
        },
        cache: false,
        contentType: false,
        processData: false
    });
});









});