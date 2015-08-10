	<!-- image for auth-page -->
    
    <div class="auth-page-header">
      <div class="background-img"><img src="<?php echo base_url();?>static/img/user-portrait/1/front-img/1-1.jpg"></img></div>
      <div class="portrait-img">
        <a href="#"><img src="<?php echo base_url();?>static/img/upload/<?php echo $user['uid'];?>/head/<?php echo $user['uid'];?>.jpg"></img></a>
      </div>
      <div class="change-background"><a href="#">Change</a></div>
      <div class="friend-follow"><?php echo anchor('#', 'Follow'); ?></div>
    </div>
  

    <div class="post-container" alt="<?php echo $user['uname']; ?>">
        <div class="post-wall">
          <?php 
            date_default_timezone_set('America/New_York');
            $enddate = date('Y-m-d H:i:s', time());
            if (!$posts) {
              echo '<div style="text-align:center; margin-top: 30px;color: #A32824"><h1>The user has no post yet.</h1></div>';
            } else {
            foreach ($posts as $post) { 
              if ($post['visible'] == 0) {
              $startdate = $post['addtime'];
              $time_pass = timeFormat($enddate, $startdate);
              if ($time_pass['year'] > 0) {
                $show_time_pass = array('number' => $time_pass['year'], 'unit' => 'year');
              } else if ($time_pass['month'] > 0) {
                $show_time_pass = array('number' => $time_pass['month'], 'unit' => 'month');
              } else if ($time_pass['day'] > 0) {
                $show_time_pass = array('number' => $time_pass['day'], 'unit' => 'day');
              } else if ($time_pass['hour'] > 0) {
                $show_time_pass = array('number' => $time_pass['hour'], 'unit' => 'hour');
              } else if ($time_pass['minute'] > 0) {
                $show_time_pass = array('number' => $time_pass['minute'], 'unit' => 'minute');
              } else {
                $show_time_pass = array('number' => $time_pass['second'], 'unit' => 'second');
              }
          ?>

          <div class="one-post" alt="<?php echo $post['id'];?>" >
            <div class="post-header">
              <div class="profile-img-post"><img src="<?php echo base_url();?>static/img/upload/<?php echo $user['uid'];?>/head/<?php echo $user['uid'];?>.jpg"></img></div>
              <div class="profile-name-post"><p><?php echo $user['uname']; ?></p></div>
              <div class="from-post-time">
                <p>
                <?php
                    echo $show_time_pass['number'] . ' ' . $show_time_pass['unit'] . ' ago';    
                ?>
                </p>
              </div>
            </div>
            <div class="post-title">
              <?php echo $post['title']; ?>
            </div>
            <div class="post-content">
              <?php echo $post['content']; ?>
            </div>
            <div class="post-footer">
              <div class="post-like" onclick="clickLike(this)" alt="<?php echo $post['id'];?>"><p></p></div>
              <div class="like-num" id="<?php echo 'like-' . $post['id']; ?>"><p><?php echo $post['like']; ?></p></div>
              <div class="post-comment" id="<?php echo 'post-comment-' . $post['id']; ?>" onclick="displayComment(this)" alt="<?php echo $post['id'];?>"><p></p></div>
              <div class="comments-num" id="<?php echo 'comments-num-' . $post['id']; ?>"><p><?php echo $post['comments']; ?></p></div>
              <div class="share-num"><p><?php echo $post['share']; ?></p></div>
              <div class="post-share"><p></p></div>
              <div style="clear: both;"></div>
            </div>



<!-- comment panel -->
            <div class="comment-panel dont-display" id="<?php echo 'comment-panel-' . $post['id']; ?>" alt="<?php echo $post['id']; ?>">
             <!--  <div class="top-comment-bar">
                <input type="text" name="reply-content" id="topCommentInput">
                <div class="submit-top-btn" id="submit-top-btn" onclick="submitTopComment(this)" alt="<?php echo $post['id'];?>"><p>Submit</p></div>
              </div> -->

              <!-- <div class="one-comment">
                <div class="commenter-img" alt='reply_id'>

                </div>
                <div class="comment-core" alt="to_id">
                    <div class="comment-content" alt="to_id">
                      <p><a href="#">Uname</a>&nbsp;relay to&nbsp;<a href="#">Touname</a>:&nbsp; abbbbbb
                      bbbbbabbbbbbabbbbbbabbbbbbabbbbbbab bbbbbabbbbb babbbbbbabbbbbbabb bbbbabbbbbbabbbbbb
                        bbbbba bbbbbb abbbbbbabbbbbbabbbbbbabbbb bbabbbb bbabbbbbb abbbbbbabbbbbbabbbbbbabbbbbb
                        bbbbbabbbbbbabbbbbb abb bbbbab bbbbbabbbb bbabbbbbbabbbbbbabbbbbbabbbbbbabbbbbbabbbbbb
                        bbbbbabbbbb babbbbbbabbbbbbabbbbbbabbbbbbabbbbbbab bbbbbabbb bbbabbbbbb abbbbbbabbbbbb
                        bbbbbabbbbb babbbbbbabbbbb babbbbbbabbbbbbabbbbbbabbbbbbabbbbbbabbbbbbabbbbbbabbbbbb
                        bbbbbabbbbbbabbbbbbabbbbbbabbbbbb abbbbbbabbbb bba bbbbbbabbbbbba bbbbbbab bbbbbabbbbbb
                        bbbbbabbbbbbabbbbb babbbbbbabbbb bbabbbbbbabbbbbb abbbbbbabbb bbbabbbbbbabbbbbbabbbbbb
                      </p>
                    </div>

                    <div class="comment-operas">
                      <div class="comment-time">
                        <p>Addtime</p>
                      </div>
                      <div class="comment-reply" onclick="showReplyPanel()">
                        <p>Reply</p>
                      </div>
                      <div style="clear: both;"></div>
                    </div>

                    <div class="reply-panel dont-display" id="reply-panel">
                      <input type="text" name="reply-content" id="innerCommentInput">
                      <div class="submit-post-btn" id="submit-post-btn"><p>Submit</p></div>
                    </div>


                </div>
                
                <div style="clear:both;"></div>

                
                
              </div> -->
            </div>

          </div>
          <?php }}} ?>
        </div> 







        <div class="user-nav" alt="<?php echo $user['uid']; ?>"> 
          <div class="friend-post">
            <div class="f-count">
              <div class="num-text"><a href="#">Friend</a></div>
              <div class="num-num"><a href="#"><?php echo $relation;?></a></div>
            </div>
            <div class="divider"><p>|</p></div>
            <div class="p-count">
              <div class="num-text"><a href="#">Post</a></div>
              <div class="num-num"><a href="#"><?php echo $user['post'];?></a></div>
            </div>
            <div style="clear:both"></div>
          </div>

          <div class="sort-by-time">
            <ul>
              <?php if ($post_cnt[0] == 0) { ?>
                <li value="0" onclick="showNoPostMessage(this)">today (<?php echo 0; ?>)</li>

              <?php  } else { ?>
                <li value="0" onclick="getPostday(this, this.value)">today (<?php echo $post_cnt[0]; ?>)</li>
              <?php } ?>
              <li value="1" onclick="getPostday(this, this.value)">recent week (<?php echo $post_cnt[1]; ?>)</li>
              <li value="2" onclick="getPostday(this, this.value)">recent month (<?php echo $post_cnt[2]; ?>)</li>
              <li value="3" onclick="getPostday(this, this.value)">recent year (<?php echo $post_cnt[3]; ?>)</li>
              <li value="4" onclick="getPostday(this, this.value)">all (<?php echo $post_cnt[4]; ?>)</li>
            </ul>
          </div>

          <div class="visitor-wall">
            <div class="visitor-count"><p>Visitor (<?php echo $visit_num;?>)</p></div>
            <?php 
              $count = count($visitors);
              $has_show = 0;
              for ($i = 0; $i < 3; $i++) { ?>
                <div class="visitor-row">
                  <ul>
                    <?php 
                    for ($j = 0; $j < 3; $j++) { 
                      if ($has_show < ($count - 1)) { ?>
                        <li><a href="<?php echo base_url();?>index.php/user/userpublic/<?php echo $visitors[$has_show];?>"><img src="<?php echo base_url();?>static/img/upload/<?php echo $visitors[$has_show];?>/head/<?php echo $visitors[$has_show]?>.jpg"></img></a></li> 
                        <?php $has_show += 1; 
                      } else { ?>
                        <li><img src="<?php echo base_url();?>static/img/upload/none-user.jpg"></img></li>
                      <?php }}?>
                  </ul>
                </div>
                <?php } ?>
          </div>

          <div class="visit-trend">
            <p>Visitor trend</p>
            <img src="<?php echo base_url();?>static/img/user-portrait/1/trend/trend.jpg"></img>
          </div>
        </div>
    </div>

	<!-- block for post in the left -->
	

<!-- 	<div class="user-nav">

	</div> -->