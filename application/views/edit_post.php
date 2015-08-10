
<div class="tmp-content">

</div>

<div class="post-greeting" >
    <h1>Edit your post</h1>
</div>

<div id="category-select">
    <p>select category</p>
    <select id="selector-hook">
       <option value="1" selected>Social News</option>
       <option value="2">Music</option>
       <option value="3">Sport</option>
       <option value="4">Video Games</option>
    </select>
</div>

<div class="add_post-title">
    <input type="text" value="Post title here"></input>
</div>
<div style="clear: both;"></div>

<!--style给定宽度可以影响编辑器的最终宽度-->
<script type="text/plain" id="myEditor" style="width:100%;height:240px;border: 1px solid #343642">
    <p>Put your story here!</p>
</script>



<div class="clear"></div>


<div class="post-submit-btn">
    <p>private:</p><input type="checkbox" id="private-check"></input>
    <div style="clear:both;"></div>
    <input value="Save" type="button" onclick="return edit_post();"/></input>
</div>
<!-- <table style="margin-bottom: 20px">
    <tr>
        <td>
            <input value="Submit" type="button" class="post-submit-btn" onclick="getContent()"/>Submit</button>
            <button class="btn" onclick="deleteEditor()"/>删除编辑器</button>
        </td>
    </tr>
</table> -->

<div>
    <h3 id="focush2"></h3>
</div>
<script type="text/javascript">
    //实例化编辑器
    
    $(document).ready(function($){
        var $url = window.location.href;
        var um = UM.getEditor('myEditor');
        var $id = $url.split("/")[$url.split('/').length - 1];
        
        
        // alert($id);
        $.ajax({
            type:"POST",
            url:'http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/initEditPage',
            data: {
                'aid':$id
            },
            dataType: "json",
            success: function(data) {
                // alert('here');
                // alert(data);
                $.each(data, function(index, element) {
                    init_category = element.category;
                    $('.add_post-title').find('input[type="text"]').val(element.title);
                    um.setContent(element.content);
                    for (var i = 0; i < document.getElementById("selector-hook").options.length;i++) {
                        //alert(document.getElementById("selector-hook").options[i].value);
                        if (document.getElementById("selector-hook").options[i].value == element.category) {
                            document.getElementById("selector-hook").options[i].selected = true;
                            break;
                        }
                    }
                    if (element.visible == 1)
                    document.getElementById("private-check").checked = true;
                });
            },
            error: function() {
                alert('error');
            }
        });
    });
   

    function edit_post() {
        var $category = $('#category-select').find('option:selected').attr('value');
        // alert($category);
        var $title = $('.add_post-title').find('input[type="text"]').val();
        if (document.getElementById("private-check").checked) {
            var $visible = 1; 
        } else {
            var $visible = 0;
        }
        
        var $url = window.location.href;
        var $id = $url.split("/")[$url.split('/').length - 1];
        var $content = UM.getEditor('myEditor').getContent();
        $.post('http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/updateEditedPost', 
                {
                    'init_category': init_category,
                    'id': $id,
                    'visible': $visible,
                    'category': $category,
                    'title': $title,
                    'content': $content
                }, function (data) {
                    window.location.href = '../../login_home' ;  // Redirect to this page
                });

        return true;
    }

</script>