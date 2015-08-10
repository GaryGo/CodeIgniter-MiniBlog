function currentPage(obj) {
	$(obj).addClass("current_page_item");
	$(obj).siblings().removeClass("current_page_item");
	$value = $(obj).attr('value');
	$.ajax({
		url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/loadPageByItem",
		data: {'value' : $value},
		type:"POST",
	    dataType:"html",
		success: function(data) {
			$('#main').empty();
			$('#main').html(data);
			if ($value == 1) {
				altRows('alternatecolor');
			}
		},
		error: function(data) {
			alert("error !" );
		}
	});
}

function altRows(id){
    if(document.getElementsByTagName){  
        
        var table = document.getElementById(id);  
        var rows = table.getElementsByTagName("tr"); 
         
        for(i = 0; i < rows.length; i++){          
            if(i % 2 == 0){
                rows[i].className = "evenrowcolor";
            }else{
                rows[i].className = "oddrowcolor";
            }      
        }
    }
}

function setPrevPage(obj) {
	$page = $(obj).siblings('#page-num').text().split('/')[0];
	if ($page == 1) {

	} else {
		// alert($page - 1);
		$.ajax({
			url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/loadPageUser",
			data: {'page' : parseInt($page) - 1},
			type:"POST",
		    dataType:"html",
			success: function(data) {
				// alert(data);
				$('#main').empty();
				$('#main').html(data);
				altRows('alternatecolor');
			},
			error: function(data) {
				alert("error !" );
			}
		});
	}
}

function setNextPage(obj) {
	$page = $(obj).siblings('#page-num').text().split('/')[0];
	$last_page = $(obj).siblings('#page-num').text().split('/')[1];
	if ($page == $last_page) {

	} else {
		// alert($page + 1);
		$.ajax({
			url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/loadPageUser",
			data: {'page' : parseInt($page) + 1},
			type:"POST",
		    dataType:"html",
			success: function(data) {
				// alert(data);
				$('#main').empty();
				$('#main').html(data);
				altRows('alternatecolor');
			},
			error: function(data) {
				alert("error !" );
			}
		});
	}
}

function editUser(obj) {
	$(obj).parent().parent().css('background-color', 'yellow');
	$(obj).parent().next().css('display','true');
	$(obj).parent().next().next().next().css('display', 'true');
	$(obj).next('span').removeAttr("onclick");
	$(obj).removeAttr("onclick");
	$siblings = $(obj).parent().siblings();
	$siblings.each(function(index) {
		if (index <= 3) {
			$tmpval = $(this).text();
			$(this).empty();
			 var inputObj = $("<input type='text'>").css("border-width","0").width($(this).width())
            .css("background-color",$(this).css("background-color")).css('padding','0px').css('margin-bottom', '0px')
            .css('font-size', '11px')
            .val($tmpval).appendTo($(this));
		}
	});
	
}

function deleteConfirmUser(obj) {
	var $id = parseInt($(obj).parent().prev().prev().prev().prev().prev().prev().text());
	// alert($id);
	$.ajax({
			url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/deleteUser",
			data: {'id': $id},
			type:"POST",
			success: function(data) {
				// alert(data);
				// alert('delete success');
			},
			error: function(data) {
				alert("delete error !" );
			}
		});
	$(obj).parent().parent().remove();
}

function deleteUser(obj) {
	$(obj).parent().parent().css('background-color', 'yellow');
	$(obj).parent().next().next().css('display','true');
	$(obj).parent().next().next().next().css('display', 'true');
	$(obj).removeAttr("onclick");
	$(obj).prev().removeAttr("onclick");
}

function confirmUser(obj) {
	$(obj).parent().parent().css('background-color', '');
	$(obj).parent().prev().find('span:first').attr('onclick', 'editUser(this)');
	$(obj).parent().css('display','none');
	$siblings = $(obj).parent().siblings();
	var $id;
	var $name;
	var $email;
	var $pw;
	$siblings.each(function(index) {
		if (index <= 3) {
			$tmpval = $(this).find('input').val();
			$(this).empty().html($tmpval);
			if (index == 0) {
				$id = parseInt($tmpval);
			}
			if (index == 1) {
				$name = $tmpval + "";
			}
			if (index ==2) {
				$email = $tmpval + "";
			}
			if (index == 3) {
				$pw = $tmpval + "";
			}
		}
		
	});
	// alert($user[3]);
	// alert($id + " " + $name + " " + $email + " " + $pw);

	$.ajax({
			url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/updateUser",
			data: {'id': $id, 'name': $name, 'email': $email, 'pw': $pw},
			type:"POST",
			success: function(data) {
				// alert(data);
				// alert('success');
			},
			error: function(data) {
				alert("error !" );
			}
		});
	$(obj).parent().prev().find("span:last").attr('onclick', 'deleteUser(this)');
	$(obj).parent().next().next().css('display', 'none');
	
}



function cancel(obj) {
	if (!$(obj).parent().prev().prev().is(':hidden')) {
		$(obj).parent().siblings().each(function(index) {
		if (index <= 3) {
			$tmpval = $(this).find('input').val();
			$(this).empty().html($tmpval);
		}
		
		});
	}
	$(obj).parent().parent().css('background-color', '');
	$(obj).parent().prev().prev().prev().find('span:first').attr('onclick', 'editUser(this)');
	$(obj).parent().prev().prev().prev().find('span:last').attr('onclick', 'deleteUser(this)');
	$(obj).parent().prev().prev().css('display', 'none');
	$(obj).parent().prev().css('display', 'none');
	$(obj).parent().css('display', 'none');
}



function search() {
	$key = $('#search-user').val();
	$.ajax({
		url: "http://localhost/~maydaygjf/adlerordering/index.php/admin/search",
			data: {'key': $key},
			type:"POST",
			dataType:"html",
			success: function(data) {
				alert("success");
				$('#main').empty();
				$('#main').html(data);
				altRows('alternatecolor');
			},
			error: function(data) {
				alert("delete error !" );
			}
		});
}







