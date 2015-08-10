jQuery(document).ready(function($){






});



function clickLike(obj) {
	
	var $id = $(obj).attr('alt');
	var $like_num = $('#like-' + $id).find('p').html();
	$.ajax({
             
             url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/likeArticle',
             type: "POST",
             data: {
             	    'id': $id
             	},
             success: function(data) {
             	if (data == "notchange") {
             		$('#like-' + $id).find('p').html($like_num);
             	} else {
             		$('#like-' + $id).find('p').html(data);
             	}
             },
             error: function() {
             	alert('error');
             }
		});
}


// get posts by time
function getPostday(obj, unit) {
      var $uid = $('.user-nav').attr('alt');
      // alert($uid);
      $('.post-wall').empty();
      $('.sort-by-time li').css('color', '#fff');
      obj.style.color = "yellow";

      $.ajax({
            url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/getPostGroupByWhat',
            type: "POST",
            data: {
                  'uid' : $uid,
                  'unit' : unit
            },
            dataType: "json",
            success: function(data) {
                  if (!data) {
                        $('.post-wall').html('<div style="text-align:center; margin-top: 30px;color: #A32824"><h1>no post yet.</h1></div>');
                  } else {
                        var uname = $('.post-container').attr('alt');
                        $.each(data, function(index, element) {
                              // alert(element.id);
                              var one_post = document.createElement("div");
                              one_post.className = "one-post";
                              var post_header = document.createElement("div");
                              post_header.className = "post-header";
                              var profile_img_post = document.createElement("div");
                              profile_img_post.className = "profile-img-post";
                              var profile_name_post = document.createElement("div");
                              profile_name_post.className = "profile-name-post";
                              var from_post_time = document.createElement("div");
                              from_post_time.className = "from-post-time";
                              var post_title = document.createElement("div");
                              post_title.className = "post-title";
                              var post_content = document.createElement("div");
                              post_content.className = "post-content";
                              var post_footer = document.createElement("div");
                              post_footer.className = "post-footer";
                              var post_like = document.createElement("div");
                              post_like.className = "post-like";
                              var like_num = document.createElement("div");
                              like_num.className = "like-num";
                              var post_comment = document.createElement("div");
                              post_comment.className = "post-comment";
                              var comments_num = document.createElement("div");
                              comments_num.className = "comments-num";
                              var share_num = document.createElement("div");
                              share_num.className = "share-num";
                              var post_share = document.createElement("div");
                              post_share.className = "post-share";
                              var  edit_and_delect = document.createElement("div");
                              edit_and_delect.className = "edit-and-delect";
                              var  delete_post = document.createElement("div");
                              delete_post.className = "delete-post";
                              var  edit_post = document.createElement("div");
                              edit_post.className = "edit-post";

                              var  comment_panel = document.createElement("div");
                              comment_panel.className = "comment-panel dont-display";

                              // post header construction
                              var img = $('<img/>');
                              img.attr("src", "http://localhost/~maydaygjf/Hunter_Hunter/static/img/upload/" + element.uid + "/head/" + element.uid + ".jpg");
                              img.appendTo(profile_img_post);
                              post_header.appendChild(profile_img_post);
                              profile_name_post.innerHTML = "<p>" + uname + "</p>";
                              post_header.appendChild(profile_name_post);

                              var show_time = getDateDiff(element.addtime);
                              from_post_time.innerHTML = "<p>" + show_time['number'] + " " + show_time['unit'] + " ago</p>";
                              post_header.appendChild(from_post_time);

                              one_post.appendChild(post_header);

                              //post title
                              if (element.visible == 1) {
                                    var the_title = element.title + "<p>(private)</p>";
                              } else {
                                    var the_title = element.title + "<p>(public)</p>";
                              }
                              post_title.innerHTML = the_title;
                              one_post.appendChild(post_title);

                              // post content
                              post_content.innerHTML = element.content;
                              one_post.appendChild(post_content);

                              //post footer
                              post_like.setAttribute("onclick", "clickLike(this)");
                              post_like.setAttribute("alt", element.id);
                              post_like.innerHTML = "<p></p>";
                              post_footer.appendChild(post_like);

                              like_num.setAttribute("id", "like-" + element.id);
                              like_num.innerHTML = "<p>" + element.like + "</p>";
                              post_footer.appendChild(like_num);
                              post_comment.innerHTML="<p></p>";
                              post_comment.id="post-comment-"+element.id;
                              post_comment.setAttribute('onclick', 'displayComment(this)');
                              post_comment.setAttribute('alt', element.id);
                              post_footer.appendChild(post_comment);

                              comments_num.innerHTML = "<p>" + element.comments + "</p>";
                              comments_num.id = "comments-num-" + element.id;
                              post_footer.appendChild(comments_num);
                              share_num.innerHTML = "<p>" + element.share + "</p>";
                              post_footer.appendChild(share_num);

                              post_share.innerHTML = "<p></p>";
                              var clear_div = document.createElement("div");
                              clear_div.setAttribute("style", "clear:both;");
                              post_footer.appendChild(clear_div);
                              one_post.appendChild(post_footer);

                              // edit and delect
                              delete_post.innerHTML = "<p>Delete</p>";
                              edit_and_delect.appendChild(delete_post);

                              
                              var a_ = document.createElement("a");
                              a_.setAttribute("href", "http://localhost/~maydaygjf/Hunter_Hunter/index.php/article/toedit/" + element.id);
                              a_.innerHTML = "Edit";
                              edit_post.appendChild(a_);
                              edit_and_delect.appendChild(edit_post);

                              
                              var clear_div2 = document.createElement("div");
                              clear_div2.setAttribute("style", "clear:both;");
                              edit_and_delect.appendChild(clear_div2);
                              one_post.setAttribute("alt", element.id);
                              one_post.appendChild(edit_and_delect);

                              comment_panel.id = "comment-panel-" + element.id;
                              comment_panel.setAttribute('alt', element.id);
                              one_post.appendChild(comment_panel);

                              
                              $('.post-wall').append(one_post);
                        });
                  }
          
            },
            error: function() {
                  alert('post error');
            }
      });
}

function getDateDiff(startTime) {
      startTime = startTime.replace(/-/g, "/");
      var sTime = new Date(startTime);
      var now = new Date();

      $year=Math.floor((now - sTime)/1000/946080000);
      $month=Math.floor((now - sTime)/1000/2592000);
      $day=Math.floor((now - sTime)/1000/86400);
      $hour=Math.floor((now - sTime)/1000%86400/3600);
      $minute=Math.floor((now - sTime)/1000%86400/60);
      $second=Math.floor((now - sTime)/1000%86400%60);
      if ($year > 0) {
            return {'number' : $year, 'unit' : 'year'};
      } else if ($month > 0) {
            return {'number' : $month, 'unit' : 'month'};
      } else if ($day > 0) {
            return {'number' : $day, 'unit' : 'day'};
      } else if ($hour > 0) {
            return {'number' : $hour, 'unit' : 'hour'};
      } else if ($minute > 0) {
            return {'number' : $minute, 'unit' : 'minute'};
      } else {
            return {'number' : $second, 'unit' : 'second'};
      }

}




function showReplyPanel(obj) {
      $(obj).parent('.comment-operas').siblings('.reply-panel').toggleClass('dont-display');
      // $("#reply-panel").toggleClass("dont-display");
}


function showNoPostMessage(obj) {
      $('.sort-by-time li').css('color', '#fff');
      obj.style.color = "yellow";
      $('.post-wall').empty().html('<div style="text-align:center; margin-top: 30px;color: #A32824"><h1>The user has no post yet.</h1></div>');
}

function displayComment(obj) {
      var $aid = $(obj).attr('alt');
      $('#comment-panel-'+$aid).toggleClass("dont-display");
      $('#comment-panel-'+$aid).empty();
      // <div class="top-comment-bar">
      //           <input type="text" name="reply-content" id="topCommentInput">
      //           <div class="submit-top-btn" id="submit-top-btn" onclick="submitTopComment(this)" alt="<?php echo $post['id'];?>"><p>Submit</p></div>
      //         </div>
      
      var top_comment_bar = document.createElement("div");
      top_comment_bar.className = "top-comment-bar";
      var the_input0 = document.createElement("input");
      the_input0.type = "text";
      the_input0.id = "topCommentInput-"+$aid;
      var submit_top_btn = document.createElement("div");
      submit_top_btn.className = "submit-top-btn";
      submit_top_btn.id = "submit-top-btn";
      submit_top_btn.setAttribute("alt", $aid);
      submit_top_btn.innerHTML = "<p>Submit</p>";
      submit_top_btn.setAttribute("onclick", "submitTopComment(this)");
      top_comment_bar.appendChild(the_input0);
      top_comment_bar.appendChild(submit_top_btn);
      $('#comment-panel-'+$aid).append(top_comment_bar);
      
      $.ajax({
            url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/comment/getAllCommentById',
            type: "POST",
            data: {
                  'aid' : $aid
            },
            dataType:"json",
            success: function(data) {
                  
                  if (data == "nocomment") {
                        
                  } else { 
                        // alert("here");
                        $.each(data, function(index, element) {
                              // $('.comment-panel').html("here a comment");
                              var one_comment = document.createElement("div");
                              one_comment.className = "one-comment";
                              var commenter_img = document.createElement("div");
                              commenter_img.className = "commenter-img";
                              var comment_core = document.createElement("div");
                              comment_core.className = "comment-core";
                              var comment_content = document.createElement("div");
                              comment_content.className = "comment-content";
                              var comment_operas = document.createElement("div");
                              comment_operas.className = "comment-operas";
                              var comment_time = document.createElement("div");
                              comment_time.className = "comment-time";
                              var comment_reply = document.createElement('div');
                              comment_reply.className = "comment-reply";
                              comment_reply.setAttribute("onclick", "showReplyPanel(this)");
                              var div_clear2 = document.createElement("div");
                              div_clear2.setAttribute("style", "clear:both;");
                              var reply_panel = document.createElement("div");
                              reply_panel.className = "reply-panel dont-display";
                              var the_input = document.createElement("input");
                              the_input.type = "text";
                              the_input.id = "innerCommentInput-"+$aid;
                              var submit_post_btn = document.createElement("div");
                              submit_post_btn.className = "submit-post-btn";
                              var div_clear1 = document.createElement("div");
                              div_clear1.setAttribute("style", "clear:both;");

                              commenter_img.innerHTML = "<img src=http://localhost/~maydaygjf/Hunter_Hunter/static/img/upload/" + element.uid + "/head/" + element.uid + ".jpg></img>"
                              one_comment.appendChild(commenter_img);

                              comment_content.setAttribute("alt", element.touid);
                              if (element.touid == 0) {
                                    comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>:&nbsp;" + element.content + "</p>";
                              } else {
                                    comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>&nbsp;reply to&nbsp;<a href='#'>" + element.touname + "</a>:&nbsp;" + element.content + "</p>";
                              }

                              comment_core.appendChild(comment_content);
                              
                              comment_time.innerHTML = "<p>" + element.addtime + "</p>";
                              comment_operas.appendChild(comment_time);
                              comment_reply.innerHTML = "<p>Reply</p>";
                              comment_operas.appendChild(comment_reply);
                              comment_operas.appendChild(div_clear2);
                              comment_core.appendChild(comment_operas);
                              

                              
                              reply_panel.id = "reply-panel";
                              reply_panel.setAttribute('alt', element.uid);
                              reply_panel.appendChild(the_input);
                              submit_post_btn.id = "submit_post_btn";
                              submit_post_btn.innerHTML = "<p>Submit</p>";
                              submit_post_btn.setAttribute("alt", $aid);
                              submit_post_btn.setAttribute('onclick', 'submitInnerComment(this)');

                              reply_panel.appendChild(submit_post_btn);
                              comment_core.appendChild(reply_panel);
                              one_comment.appendChild(comment_core);
                              one_comment.appendChild(div_clear1);
                              one_comment.id = "one-comment-" + element.uid;
                              one_comment.setAttribute('alt', element.touid);
                              $('#comment-panel-'+$aid).append(one_comment);

                        });
                      
                  }
            },
      });

}

function submitTopComment(obj) {
      var $aid = $(obj).attr('alt');
      var $content = $('#topCommentInput-'+$aid).val();
      
      $.ajax({
            url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/comment/addToAll',
            type: "POST",
            data: {
                  'content' : $content,
                  'aid' : $aid
            },
            success: function(data) {
                  // alert(data);
                  afterSubmitComment($aid);


            },
            error: function(data) {
                  alert("add failed");
            }
      });

}

function submitInnerComment(obj) {
      var $aid = $(obj).attr('alt');
      // var $content = $('#innerCommentInput-'+$aid).val();
      var $content = $(obj).siblings('input').val();
      var $touid = $(obj).parent().attr('alt');
      // alert($touid);
      $.ajax({
            url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/comment/addToUser',
            type: "POST",
            data: {
                  'content' : $content,
                  'aid' : $aid,
                  'touid' : $touid
            },
            success: function(data) {
                  // alert(data);
                  afterSubmitComment($aid);


            },
            error: function(data) {
                  alert("add failed");
            }
      });
}


// function afterSubmitComment(aid) {
//       $('#comment-panel-'+aid).toggleClass("dont-display");
//       $('#comment-panel-'+aid).empty();

//       var top_comment_bar = document.createElement("div");
//       top_comment_bar.className = "top-comment-bar";
//       var the_input0 = document.createElement("input");
//       the_input0.type = "text";
//       the_input0.id = "topCommentInput-"+aid;
//       var submit_top_btn = document.createElement("div");
//       submit_top_btn.className = "submit-top-btn";
//       submit_top_btn.id = "submit-top-btn";
//       submit_top_btn.setAttribute("alt", aid);
//       submit_top_btn.innerHTML = "<p>Submit</p>";
//       submit_top_btn.setAttribute("onclick", "submitTopComment(this)");
//       top_comment_bar.appendChild(the_input0);
//       top_comment_bar.appendChild(submit_top_btn);
//       $('#comment-panel-'+aid).append(top_comment_bar);
      
//       $.ajax({
//             url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/comment/getAllCommentById',
//             type: "POST",
//             data: {
//                   'aid' : aid
//             },
//             dataType:"json",
//             success: function(data) {
                  
//                   if (data == "nocomment") {
                        
//                   } else { 
//                         // alert("here");
//                         $.each(data, function(index, element) {
//                               // $('.comment-panel').html("here a comment");
//                               var one_comment = document.createElement("div");
//                               one_comment.className = "one-comment";
//                               var commenter_img = document.createElement("div");
//                               commenter_img.className = "commenter-img";
//                               var comment_core = document.createElement("div");
//                               comment_core.className = "comment-core";
//                               var comment_content = document.createElement("div");
//                               comment_content.className = "comment-content";
//                               var comment_operas = document.createElement("div");
//                               comment_operas.className = "comment-operas";
//                               var comment_time = document.createElement("div");
//                               comment_time.className = "comment-time";
//                               var comment_reply = document.createElement('div');
//                               comment_reply.className = "comment-reply";
//                               comment_reply.setAttribute("onclick", "showReplyPanel(this)");
//                               var div_clear2 = document.createElement("div");
//                               div_clear2.setAttribute("style", "clear:both;");
//                               var reply_panel = document.createElement("div");
//                               reply_panel.className = "reply-panel dont-display";
//                               var the_input = document.createElement("input");
//                               the_input.type = "text";
//                               the_input.id = "innerCommentInput-"+aid;
//                               var submit_post_btn = document.createElement("div");
//                               submit_post_btn.className = "submit-post-btn";
//                               var div_clear1 = document.createElement("div");
//                               div_clear1.setAttribute("style", "clear:both;");

//                               commenter_img.innerHTML = "<img src=http://localhost/~maydaygjf/Hunter_Hunter/static/img/upload/" + element.uid + "/head/" + element.uid + ".jpg></img>"
//                               one_comment.appendChild(commenter_img);

//                               comment_content.setAttribute("alt", element.touid);

//                               if (element.touid == 0) {
//                                     comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>:&nbsp;" + element.content + "</p>";
//                               } else {
//                                     comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>&nbsp;reply to&nbsp;<a href='#'>" + element.touname + "</a>:&nbsp;" + element.content + "</p>";
//                               }

//                               comment_core.appendChild(comment_content);
                              
//                               comment_time.innerHTML = "<p>" + element.addtime + "</p>";
//                               comment_operas.appendChild(comment_time);
//                               comment_reply.innerHTML = "<p>Reply</p>";
//                               comment_operas.appendChild(comment_reply);
//                               comment_operas.appendChild(div_clear2);
//                               comment_core.appendChild(comment_operas);
                              

                              
//                               reply_panel.id = "reply-panel";
//                               reply_panel.setAttribute('alt', element.uid);
//                               reply_panel.appendChild(the_input);
//                               submit_post_btn.id = "submit_post_btn";
//                               submit_post_btn.innerHTML = "<p>Submit</p>";
//                               submit_post_btn.setAttribute("alt", aid);
//                               submit_post_btn.setAttribute('onclick', 'submitInnerComment(this)');
//                               reply_panel.appendChild(submit_post_btn);
//                               comment_core.appendChild(reply_panel);
//                               one_comment.appendChild(comment_core);
//                               one_comment.appendChild(div_clear1);
//                               one_comment.id = "one-comment-" + element.uid;
//                               one_comment.setAttribute('alt', element.touid);
//                               $('#comment-panel-'+aid).append(one_comment);
//                               if ($('#comment-panel-'+aid).hasClass("dont-display")) {
//                                     $('#comment-panel-'+aid).toggleClass("dont-display");
//                               }

//                         });
//                         $('#comments-num-'+aid).find('p').html(data.length);
                       
                      
//                   }
//             },
//       });
// }


function afterSubmitComment(aid) {
      $('#comment-panel-'+aid).toggleClass("dont-display");
      $('#comment-panel-'+aid).empty();

      var top_comment_bar = document.createElement("div");
      top_comment_bar.className = "top-comment-bar";
      var the_input0 = document.createElement("input");
      the_input0.type = "text";
      the_input0.id = "topCommentInput-"+aid;
      var submit_top_btn = document.createElement("div");
      submit_top_btn.className = "submit-top-btn";
      submit_top_btn.id = "submit-top-btn";
      submit_top_btn.setAttribute("alt", aid);
      submit_top_btn.innerHTML = "<p>Submit</p>";
      submit_top_btn.setAttribute("onclick", "submitTopComment(this)");
      top_comment_bar.appendChild(the_input0);
      top_comment_bar.appendChild(submit_top_btn);
      $('#comment-panel-'+aid).append(top_comment_bar);
      
      $.ajax({
            url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/comment/getAllCommentById',
            type: "POST",
            data: {
                  'aid' : aid
            },
            dataType:"json",
            success: function(data) {
                  
                  if (data == "nocomment") {
                        
                  } else { 
                        // alert("here");
                        $.each(data, function(index, element) {
                              // $('.comment-panel').html("here a comment");
                              var one_comment = document.createElement("div");
                              one_comment.className = "one-comment";
                              var commenter_img = document.createElement("div");
                              commenter_img.className = "commenter-img";
                              var comment_core = document.createElement("div");
                              comment_core.className = "comment-core";
                              var comment_content = document.createElement("div");
                              comment_content.className = "comment-content";
                              var comment_operas = document.createElement("div");
                              comment_operas.className = "comment-operas";
                              var comment_time = document.createElement("div");
                              comment_time.className = "comment-time";
                              var comment_reply = document.createElement('div');
                              comment_reply.className = "comment-reply";
                              comment_reply.setAttribute("onclick", "showReplyPanel(this)");
                              var div_clear2 = document.createElement("div");
                              div_clear2.setAttribute("style", "clear:both;");
                              var reply_panel = document.createElement("div");
                              reply_panel.className = "reply-panel dont-display";
                              var the_input = document.createElement("input");
                              the_input.type = "text";
                              the_input.id = "innerCommentInput-"+aid;
                              var submit_post_btn = document.createElement("div");
                              submit_post_btn.className = "submit-post-btn";
                              var div_clear1 = document.createElement("div");
                              div_clear1.setAttribute("style", "clear:both;");

                              commenter_img.innerHTML = "<img src=http://localhost/~maydaygjf/Hunter_Hunter/static/img/upload/" + element.uid + "/head/" + element.uid + ".jpg></img>"
                              one_comment.appendChild(commenter_img);

                              comment_content.setAttribute("alt", element.touid);

                              if (element.touid == 0) {
                                    comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>:&nbsp;" + element.content + "</p>";
                              } else {
                                    comment_content.innerHTML = "<p><a href='#'>" + element.uname + "</a>&nbsp;reply to&nbsp;<a href='#'>" + element.touname + "</a>:&nbsp;" + element.content + "</p>";
                              }

                              comment_core.appendChild(comment_content);
                              
                              comment_time.innerHTML = "<p>" + element.addtime + "</p>";
                              comment_operas.appendChild(comment_time);
                              comment_reply.innerHTML = "<p>Reply</p>";
                              comment_operas.appendChild(comment_reply);
                              comment_operas.appendChild(div_clear2);
                              comment_core.appendChild(comment_operas);
                              

                              
                              reply_panel.id = "reply-panel";
                              reply_panel.setAttribute('alt', element.uid);
                              reply_panel.appendChild(the_input);
                              submit_post_btn.id = "submit_post_btn";
                              submit_post_btn.innerHTML = "<p>Submit</p>";
                              submit_post_btn.setAttribute("alt", aid);
                              submit_post_btn.setAttribute('onclick', 'submitInnerComment(this)');
                              reply_panel.appendChild(submit_post_btn);
                              comment_core.appendChild(reply_panel);
                              one_comment.appendChild(comment_core);
                              one_comment.appendChild(div_clear1);
                              one_comment.id = "one-comment-" + element.uid;
                              one_comment.setAttribute('alt', element.touid);
                              $('#comment-panel-'+aid).append(one_comment);
                              if ($('#comment-panel-'+aid).hasClass("dont-display")) {
                                    $('#comment-panel-'+aid).toggleClass("dont-display");
                              }

                        });
                        $('#comments-num-'+aid).find('p').html(data.length);
                       
                      
                  }
            },
      });
}





