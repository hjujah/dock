<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Edit Video Gallery</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
					    <div class="row">
						    <div class="span16">

						        <h3>Gallery Videos</h3>
                  
						        <form>
                                                            <p>Select video source:</p>
                                                            <select id="video_source">
                                                                <option value="y">YouTube</option>
                                                                <option value="v">Vimeo</option>                                                                
                                                            </select>
                                                            <p>Insert video URL (For example: <b><u>http://www.youtube.com/watch?v=c0VwFq3-UI0</u></b> for YouTube or <b><u>http://vimeo.com/7615012</u></b> for Vimeo)</p>
                                                            <input type="text" id="url" name="url" />
                                                            <br />
                                                            <br />
                                                            <input class="btn primary transition" type="button" onclick="addVideo();" value="Add">
                                                            <br />
                                                            <br />                                                            
                                                            <div class="alert-message block-message" id="message-video-box" style="display: none;">
						                
						            </div>
						        </form>
						        <div id="message-image">
						        </div>
						        
						        
						        <div class="clearfix">
						            <div class="well" >
						                <ul id="grid" class="media-grid">
						                    <?php if(isset($gallery->videos) && is_array($gallery->videos) && count($gallery->videos) > 0) :?> 
						                    <?php foreach($gallery->videos as $video): ?>
						                    <li>
						                        <div class="grid-item">
						                            <img src="<?php echo $video->thumb_url; ?>"></img>
						                            <div class="item-options">
						                                <a href="" class="del-video" video_id="<?php echo $video->id; ?>" video_name="<?php echo htmlspecialchars($video->title); ?>">delete</a>
						                            </div>
						                        </div>
						                    </li>
						                    <?php endforeach; ?>
						                    <?php endif;?>
						                </ul>
						            </div>
						        </div><!-- /clearfix -->
						    </div><!-- span16 -->
					    </div><!-- row -->    
						
						<!-- content ends here -->
						<br class="clear">
						
						<div id="modal-from-dom" class="modal hide fade">
				            <div class="modal-header">
				              <a href="#" class="close">&times;</a>
				              <h3>Are you sure?</h3>
				            </div>
				            <div class="modal-body">
				              <p>That you want to delete this video.</p>
				            </div>
				            <div class="modal-footer">
				              <a id="delete-no" href="#" class="btn secondary">No</a>
				              <a id="delete-yes" href="#" class="btn danger">Yes</a>
				            </div>
				            
				            
				        </div>
				        
					</div>

					<div class="clear"></div>
				</div><!-- adminbody-content -->
				<div class="clear"></div>
			</div><!-- adminbody -->
			<div class="clear"></div>
		</div><!-- admincontent -->
		
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript" src="<?php echo base_url('js/libs/fileuploader.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/plugins/bootstrap-modal.js'); ?>"></script>
<script type="text/javascript" src="http://swfobject.googlecode.com/svn/trunk/swfobject/swfobject.js"></script>

<script type="text/javascript">
var delete_video_id;

$(function()
{
    $('#modal-from-dom').modal({
        backdrop: true,
        keyboard: true
    });
    $('#delete-yes').click(function(e){
        e.preventDefault();
        deleteVideo(delete_video_id);
    });
    $('#delete-no').click(function(e){
        e.preventDefault();
        $('#modal-from-dom').modal('hide');
    });
    $('#main-bar').dropdown();
    $('.del-video').each(function(){
        var img_id = $(this).attr('video_id');
        $(this).click(function(e){
            e.preventDefault();
            $(this).lunchModal(); 
        });
    });
});

function addVideo()
{
    var source = $('#video_source').val();
    var url = $('#url').val();
    
    if(url != '')
    {
        if(source == 'y')
        {
            var video_id = youtube_parser(url);
            var video_url = 'https://gdata.youtube.com/feeds/api/videos/' + video_id + 'v=2&alt=json';
            
            $.ajax({
                url: 'http://gdata.youtube.com/feeds/api/videos/' + video_id + '?v=2&alt=json',
                dataType: "jsonp",
                success: function(resp) {
                    parseYoutubeResponse(resp, video_id); 
                }
            });
        }
        else if(source =='v')
        {
            var video_id  = vimeo_parser(url);
            var video_url = 'http://vimeo.com/api/v2/video/' + video_id + '.json';

            $.ajax({
                type: 'GET',
                url: video_url,
                data: {format: 'jsonp'},
                dataType: 'jsonp',
                crossDomain: true,
                success: function(resp) {
                    parseVimeoResponse(resp, video_id);
                },
                error: function(resp) {
                    alert('wrong ID');
                }
            });
        }
    }
    else
    {
        $('#message-video-box').html('<b>URL field is required and cannot be empty!</b>');
        $('#message-video-box').show();
    }
}

function youtube_parser(url)
{
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[7].length == 11)
    {
        return match[7];
    }
    else
    {
        $('#message-video-box').html('<b>Incorrect url provided!</b>');
        $('#message-video-box').show();
    }
}

function vimeo_parser(url)
{
    var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;

    var match = url.match(regExp);

    if (match && match[2] != '')
    {
        return match[2];
    }
    else
    {
        $('#message-video-box').html('<b>Incorrect url provided!</b>');
        $('#message-video-box').show();
    }
}

function parseYoutubeResponse(obj, id)
{
    var title = obj.entry.title.$t;
    var video_id = id;
    var url = obj.entry.media$group.media$content[0].url;
    var thumb_url = obj.entry.media$group.media$thumbnail[0].url;
    var source = 'y';
    addDbVideo(title, video_id, url, thumb_url, source);
}

function parseVimeoResponse(obj, id)
{
    var title = obj['0']['title'];
    var video_id = id;
    var url = obj['0']['url'];
    var thumb_url = obj['0']['thumbnail_small'];
    var source = 'v';
    addDbVideo(title, video_id, url, thumb_url, source);
}

function addDbVideo(v_title, v_video_id, v_url, v_thumb_url, v_source)
{
    console.log("upisivanje u bazu =====");
    $.post(
        "<?php echo base_url('ajax/addVideoDb'); ?>",
        {
            title: encodeURIComponent(v_title),
            video_id: encodeURIComponent(v_video_id),
            url: encodeURIComponent(v_url),
            thumb_url: encodeURIComponent(v_thumb_url),
            source: v_source,
            gallery_id: <?php echo $gallery->id; ?>
        }, 
        addVideoCallBack,
        "json"
    );
}

function addVideoCallBack(data)
{
    if(data.success)
    {
        var li = $('<li>');
        var div = $('<div class="grid-item">');

        var img = $('<img>');
        img.attr('src', data.thumb_url);
        div.append(img);
        
        var optionsDiv  = '<div class="item-options">';
            optionsDiv += '<a href="" class="del-video" video_id="' + data.id + '" image_name="">delete</a>';
            optionsDiv += '</div>';

        div.append(optionsDiv);

        $('.del-video', div).click(function(e){
            e.preventDefault();
            $(this).lunchModal();
        });

        li.append(div);
        $('#grid').append(li);
        
        $('#url').val('');
        $('#message-video-box').hide();
    }   
    else
    {
        renderMessage(data.error, $('#message-image'), 'error');
    }
}

function deleteVideo(id)
{
    $.get('<?php echo base_url('ajax/deleteVideo'); ?>', { id : id}, deleteVideoCallBack, 'json' );
    return false;   
}
    
function deleteVideoCallBack(data)
{
    if(data.success)
    {
        $('#modal-from-dom').modal('hide');
        $('.del-video').each(function()
        {
            if($(this).attr('video_id') == data.id)
            {
                $(this).parent().parent().remove();
            }
        });    
    }
    else
    {
        alert(data.error);
    }    
}

function renderMessage(message, element, type)
{
    $.scrollTo(element, 400);

    var msg = $('<div>').addClass('alert-message block-message');
    msg.append('<p>'+message+'</p>');
    if(type == 'error')
    {
        msg.addClass('error');
        element.html('');
        element.append(msg);
    }
    else if(type == 'success')
    {
        msg.addClass('success');
        element.html('');
        element.append(msg);
        setTimeout(function(){
            msg.fadeOut();
        }, 3000);
    }
}

$.fn.lunchModal = function(){
    delete_video_id = $(this).attr('video_id');
    $('#modal-from-dom').modal('show');
}

</script>

<?php $this->load->view('admin/page-end'); ?>