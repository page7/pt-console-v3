<?php self::unpjax('container', array('title'=>'Banner', 'preload'=>'')); ?>

<h1 class="page-header">Banner</h1>

<style>
.banner .image { width:300px; height:150px; }
.image-upload .image-loading:before, .image-upload .image-empty:before { margin-top:35px; }
.image-upload .sortable-placeholder { display:inline-block; width:300px; height:150px; box-sizing:border-box; border:#ccc dashed 2px; border-radius:4px; margin-right:10px; }
</style>

<!-- form -->
<form class="banner" id="form" role="form">

    <h3> Images </h3>
    <p>Recommended image size: 1200 x 600px</p>

    <div class="image-upload" style="margin:30px 5% 0;">
        <?php
        if ($banners) {
            foreach ($banners as $k => $v) {
        ?>
        <div class="image" style="background-image:url(<?php echo UPLOAD_URL . $v['picture']; ?>);">
            <div class="action">
                <a class="link" href="javascript:;"><span class="glyphicon glyphicon-link"></span></a>
                <a class="rm" href="javascript:;"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <input type="hidden" name="link[]" value="<?php echo $v['link']; ?>" />
            <input type="hidden" name="image[]" value="<?php echo $v['picture']; ?>" />
        </div>
        <?php
            }
        }
        ?>
        <a id="image" class="image image-empty">Choose a image</a>
    </div>

    <hr style="margin-top:50px" />

    <div class="form-group">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary pull-right btn-lg btn-save">Save</button>
        </div>
    </div>

</div>


<div id="modal-link" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Link</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label">Url</label>
                    <input type="text" class="form-control" value="" placeholder="Press a full url with http://" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-save">Setting</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo RESOURCES_URL; ?>js/plupload/plupload.full.min.js"></script>
<script src="<?php echo RESOURCES_URL; ?>js/jquery.sortable.js"></script>

<script>
$(function(){

    $(".btn-save").click(function(){
        var data = $('#form').serialize();
        $.post("<?php echo BASE_URL; ?>?module=banner", data, function(data){
            if (data.s == 0){
               alert('Save successfully.', 'success');
            } else {
               alert(data.err, 'error');
            }
        }, "json");
    });

    // Picture uploader
    var tmpl = '<div class="action">\
                    <a class="link" href="javascript:;"><span class="glyphicon glyphicon-link"></span></a>\
                    <a class="rm" href="javascript:;"><span class="glyphicon glyphicon-remove"></span></a>\
                </div>\
                <input type="hidden" name="link[]" value="" />';
    window.image_uploader("<?php echo MODULE; ?>", "image", true, tmpl);

    var uploads = $(".image-upload"),
        modal = $("#modal-link");

    $("#banner").bind("uploader:complete", function(){
        uploads.sortable("destroy").sortable({items:".image"});
    });

    // Remove
    uploads.on("click", ".image .rm", function(){
        $(this).parents(".image").remove();
    });

    // Link
    uploads.on("click", ".image .link", function(){
        var b = $(this), img = b.parents(".image").eq(0); l = img.children("input").eq(1).val();
        modal.find("input").val(l);
        modal.data("target", img);
        modal.modal("show");
    });

    modal.find(".btn-save").click(function(){
        var target = modal.data("target"),
            txt = modal.find("input").val();
        target.find("input").eq(1).val(txt);
        modal.modal("hide");
    });

    // Sort
    uploads.sortable({items:".image"});
});

</script>