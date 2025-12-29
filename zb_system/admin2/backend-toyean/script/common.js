$(function(){
	//右上角用户菜单
	$(document).on('click', '.userlink', function(e){
		e.stopPropagation();
		$(".usermenu").toggleClass("on");
	});
	$(document).on("click",function(e){
		if (!$(e.target).closest('.userlink, .usermenu').length) {
			$(".usermenu").removeClass("on");
		}
	});

	//开关灯
	!function(){
		if ((/;\s*night=([^;]*)/.exec(';'+document.cookie)||[,])[1] !== '0') {
			document.body.classList.add('night');
		}
	}();
	if(toyean.night){
		if((new Date().getHours() > toyean.setnightstart || new Date().getHours() < toyean.setnightover) && toyean.setnightauto){
			$(".theme").hide();
			zbp.cookie.set('night','1');
			$('body').addClass('night');
			$(".theme").attr("title","开灯").addClass("dark");
			console.log('夜间模式自动开启');
		}else if(toyean.setnightauto){
			$(".theme").hide();
			zbp.cookie.set('night','0');
			$('body').removeClass('night');
			$(".theme").attr("title","关灯").removeClass("dark");
			console.log('夜间模式自动关闭');
		}else{
			$(".theme").show();
		}
		if(zbp.cookie.get('night') == '1' || $('body').hasClass('night')){
			$(".theme").attr("title","开灯").addClass("dark");
		}else{
			$(".theme").attr("title","关灯").removeClass("dark");
		}
		$(".theme").on("click",function(){
			if(zbp.cookie.get('night') == '1' || $('body').hasClass('night')){
				zbp.cookie.set('night','0');
				$('body').removeClass('night');
				$(".theme").attr("title","关灯").removeClass("dark");
				console.log('夜间模式关闭');
			}else{
				zbp.cookie.set('night','1');
				$('body').addClass('night');
				$(".theme").attr("title","开灯").addClass("dark");
				console.log('夜间模式开启');
			}
		});
	}

	//菜单展开与折叠
	$(document).on('click', '.menuico', function (e) {
		e.stopPropagation();
		const flag = !$('.side').hasClass('on');   // 点击后要变成的状态
		$(".side,.fademask").toggleClass('on', flag);
		zbp.cookie.set('side', flag ? '1' : '0');   // 你自己的封装
	});

	$(document).on('click', '.sideclose,.fademask', function (e) {
		e.stopPropagation();
		const flag = !$('.side').hasClass('on');   // 点击后要变成的状态
		$(".side,.fademask").toggleClass('on', flag);
		zbp.cookie.set('side', flag ? '1' : '0');   // 你自己的封装
	});

	/* 读：DOM 就绪后恢复 */
	const stored = zbp.cookie.get('side');
	if (stored === '1') {
		$('.side').addClass('on');
		$('.fademask').addClass('on');
	}

	//主菜单tips
	$('<div class="menutip" id="menutip"></div>').appendTo('body');
	const $menu = $('.menu');
	const $menuItems = $menu.find('a');
	const $tooltip = $('#menutip');

	// 显示tips
	function showTooltip($link) {
		const title = $link.data('title');
		if (!title) return;
		// 获取菜单位置
		const linkRect = $link[0].getBoundingClientRect();
		// 设置tips内容
		$tooltip.text(title);
		// Y定位计算
		let top = linkRect.top + (linkRect.height / 2) - ($tooltip.outerHeight() / 2);
		// 确保tips不会超出屏幕
		const windowHeight = $(window).height();
		const tooltipHeight = $tooltip.outerHeight();
		if (top < 10) {
			top = 10;
		} else if (top + tooltipHeight > windowHeight - 10) {
			top = windowHeight - tooltipHeight - 10;
		}
		// 定位
		$tooltip.css({
			top: top
		});
		$tooltip.show();
	}

	// 隐藏tips
	function hideTooltip() {
		$tooltip.hide();
	}

	// 初始化
	$menuItems.each(function() {
		const $link = $(this);
		// 鼠标进入
		$link.on('mouseenter', function() {
			if ($('.side').hasClass('on')) {
				showTooltip($(this));
			}
		});
		// 鼠标离开
		$link.on('mouseleave', function() {
			hideTooltip();
		});
	});

	// 菜单滚动时隐藏tips
	$menu.on('scroll', function() {
		hideTooltip();
	});

	// 窗口大小变化重新计算
	$(window).on('resize', function() {
		if ($tooltip.is(':visible')) {
			let $activeLink = null;
			// 找到当前鼠标所在的菜单项
			$menuItems.each(function() {
				const $link = $(this);
				if ($link.is(':hover')) {
					$activeLink = $link;
					return false; // 退出循环
				}
			});
			if ($activeLink) {
				showTooltip($activeLink);
			} else {
				hideTooltip();
			}
		}
	});
});