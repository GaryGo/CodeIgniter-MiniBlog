<div class="post-greeting" >
    <h1>What's new?</h1>
</div>

<div id="category-select">
    <p>select category</p>
    <select>
       <option value="1" selected alt="0">Social News</option>
       <option value="2" alt="2">Music</option>
       <option value="3" alt="7">Sport</option>
       <option value="4" alt="9">Video Games</option>
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
<div id="btns" style="margin-bottom: 20px;" >
    <table>
        <tr>
            <td>
                <button class="btn" unselected="on" onclick="getAllHtml()">获得整个html的内容</button>&nbsp;
                <button class="btn" onclick="getContent()">获得内容</button>&nbsp;
                <button class="btn" onclick="setContent()">写入内容</button>&nbsp;
                <button class="btn" onclick="setContent(true)">追加内容</button>&nbsp;
                <button class="btn" onclick="getContentTxt()">获得纯文本</button>&nbsp;
                <button class="btn" onclick="getPlainTxt()">获得带格式的纯文本</button>&nbsp;
                <button class="btn" onclick="hasContent()">判断是否有内容</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="setFocus()">编辑器获得焦点</button>&nbsp;
                <button class="btn" onmousedown="isFocus();return false;">编辑器是否获得焦点</button>&nbsp;
                <button class="btn" onclick="doBlur()">编辑器取消焦点</button>&nbsp;
                <button class="btn" onclick="insertHtml()">插入给定的内容</button>&nbsp;
                <button class="btn" onclick="getContentTxt()">获得纯文本</button>&nbsp;
                <button class="btn" id="enable" onclick="setEnabled()">可以编辑</button>&nbsp;
                <button class="btn" onclick="setDisabled()">不可编辑</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="UM.getEditor('myEditor').setHide()">隐藏编辑器</button>&nbsp;
                <button class="btn" onclick="UM.getEditor('myEditor').setShow()">显示编辑器</button>&nbsp;
                <button class="btn" onclick="UM.getEditor('myEditor').setHeight(300)">设置编辑器的高度为300</button>&nbsp;
                <button class="btn" onclick="UM.getEditor('myEditor').setWidth(1200)">设置编辑器的宽度为1200</button>
            </td>
        </tr>

    </table>
</div>

<div class="post-submit-btn">
    <p>private:</p><input type="checkbox" id="private-check"></input>
    <div style="clear:both;"></div>
    <input value="Submit" type="button" onclick="return add_post();"/></input>
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
    var um = UM.getEditor('myEditor');
    // um.addListener('blur',function(){
    //     $('#focush2').html('编辑器失去焦点了')
    // });
    // um.addListener('focus',function(){
    //     $('#focush2').html('')
    // });
    //按钮的操作
    function insertHtml() {
        var value = prompt('插入html代码', '');
        um.execCommand('insertHtml', value)
    }
    function isFocus(){
        alert(um.isFocus())
    }
    function doBlur(){
        um.blur()
    }
    function createEditor() {
        enableBtn();
        um = UM.getEditor('myEditor');
    }
    function getAllHtml() {
        alert(UM.getEditor('myEditor').getAllHtml())
    }
    function getContent() {
        var arr = [];
        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
        arr.push("内容为：");
        arr.push(UM.getEditor('myEditor').getContent());
        alert(arr.join("\n"));
    }
    function getPlainTxt() {
        var arr = [];
        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
        arr.push("内容为：");
        arr.push(UM.getEditor('myEditor').getPlainTxt());
        alert(arr.join('\n'))
    }
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用umeditor')方法可以设置编辑器的内容");
        UM.getEditor('myEditor').setContent('欢迎使用umeditor', isAppendTo);
        alert(arr.join("\n"));
    }
    function setDisabled() {
        UM.getEditor('myEditor').setDisabled('fullscreen');
        disableBtn("enable");
    }

    function setEnabled() {
        UM.getEditor('myEditor').setEnabled();
        enableBtn();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UM.getEditor('myEditor').selection.getRange();
        range.select();
        var txt = UM.getEditor('myEditor').selection.getText();
        alert(txt)
    }

    function getContentTxt() {
        var arr = [];
        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
        arr.push("编辑器的纯文本内容为：");
        arr.push(UM.getEditor('myEditor').getContentTxt());
        alert(arr.join("\n"));
    }
    function hasContent() {
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UM.getEditor('myEditor').hasContents());
        alert(arr.join("\n"));
    }
    function setFocus() {
        UM.getEditor('myEditor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UM.getEditor('myEditor').destroy();
    }
    function disableBtn(str) {
        var div = document.getElementById('btns');
        var btns = domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            if (btn.id == str) {
                domUtils.removeAttributes(btn, ["disabled"]);
            } else {
                btn.setAttribute("disabled", "true");
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById('btns');
        var btns = domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            domUtils.removeAttributes(btn, ["disabled"]);
        }
    }

    function add_post() {
        var $category = $('#category-select').find('option:selected').attr('value');
        var $title = $('.add_post-title').find('input[type="text"]').val();
        if (document.getElementById("private-check").checked) {
            var $visible = 1; 
        } else {
            var $visible = 0;
        }
        // alert($title);
        var $content = UM.getEditor('myEditor').getContent();
        // alert($category);
        $.post('http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/add', 
                {
                    'visible': $visible,
                    'category': $category,
                    'title': $title,
                    'content': $content
                }, function (data) {
                    window.location.href = 'login_home' ;  // Redirect to this page
                });

        return true;
    }

</script>