<!doctype html>
<?php global $woocommerce; ?>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ''; } ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php wp_head(); ?>
		<script type="text/javascript" id="wa_u" defer></script>
		<script>
			//<![CDATA[
			var wa_pageName = location.pathname;    // customize the page name here;
			wa_account = "B29E96939D9087A8908D948C";
			wa_location=11;
			wa_MultivariateKey = '';    //  Set this variable to perform multivariate testing
			var wa_c = new RegExp('__wa_v=([^;]+)').exec(document.cookie),
				wa_tz = new Date(),
				wa_rf = document.referrer,
				wa_sr = location.search,
				wa_hp = 'http'+(location.protocol=='https:'?'s':'');

			if (top !== self) {
				wa_rf = top.document.referrer;
				wa_sr=top.location.search;
			}
			if (wa_c != null) {
				wa_c = wa_c[1];
			} else {
				wa_c = wa_tz.getTime();
				document.cookie = '__wa_v=' + wa_c + ';path=/;expires=1/1/' + (wa_tz.getUTCFullYear()+2);
			}

			wa_img = new Image();
			wa_img.src = wa_hp + '://counter.hitslink.com/statistics.asp?v=1&s=11&eacct=' + wa_account + '&an=' + escape(navigator.appName) + '&sr=' + escape(wa_sr) + '&rf=' + escape(wa_rf) + '&mvk=' + escape(wa_MultivariateKey) + '&sl=' + escape(navigator.systemLanguage) + '&l=' + escape(navigator.language) + '&pf=' + escape(navigator.platform) + '&pg=' + escape(wa_pageName) + '&cd=' + screen.colorDepth + '&rs=' + escape(screen.width + ' x ' + screen.height)+'&je=' + navigator.javaEnabled() + '&c=' + wa_c + '&tks=' + wa_tz.getTime();
			document.getElementById('wa_u').src = wa_hp + '://counter.hitslink.com/track.js';
			//]]>

					/*window.lpTag=window.lpTag||{};if(typeof window.lpTag._tagCount==='undefined'){window.lpTag={site:'21430514'||'',section:lpTag.section||'',autoStart:lpTag.autoStart===false?false:true,ovr:lpTag.ovr||{},_v:'1.6.0',_tagCount:1,protocol:'https:',events:{bind:function(app,ev,fn){lpTag.defer(function(){lpTag.events.bind(app,ev,fn);},0);},trigger:function(app,ev,json){lpTag.defer(function(){lpTag.events.trigger(app,ev,json);},1);}},defer:function(fn,fnType){if(fnType==0){this._defB=this._defB||[];this._defB.push(fn);}else if(fnType==1){this._defT=this._defT||[];this._defT.push(fn);}else{this._defL=this._defL||[];this._defL.push(fn);}},load:function(src,chr,id){var t=this;setTimeout(function(){t._load(src,chr,id);},0);},_load:function(src,chr,id){var url=src;if(!src){url=this.protocol+'//'+((this.ovr&&this.ovr.domain)?this.ovr.domain:'lptag.liveperson.net')+'/tag/tag.js?site='+this.site;}var s=document.createElement('script');s.setAttribute('charset',chr?chr:'UTF-8');if(id){s.setAttribute('id',id);}s.setAttribute('src',url);document.getElementsByTagName('head').item(0).appendChild(s);},init:function(){this._timing=this._timing||{};this._timing.start=(new Date()).getTime();var that=this;if(window.attachEvent){window.attachEvent('onload',function(){that._domReady('domReady');});}else{window.addEventListener('DOMContentLoaded',function(){that._domReady('contReady');},false);window.addEventListener('load',function(){that._domReady('domReady');},false);}if(typeof(window._lptStop)=='undefined'){this.load();}},start:function(){this.autoStart=true;},_domReady:function(n){if(!this.isDom){this.isDom=true;this.events.trigger('LPT','DOM_READY',{t:n});}this._timing[n]=(new Date()).getTime();},vars:lpTag.vars||[],dbs:lpTag.dbs||[],ctn:lpTag.ctn||[],sdes:lpTag.sdes||[],ev:lpTag.ev||[]};lpTag.init();}else{window.lpTag._tagCount+=1;}*/
		</script>
		<script>
			(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5661895"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
		</script>
		<!-- TrustBox script -->
		<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
		<!-- End Trustbox script -->
		<noscript>
			<img src="//bat.bing.com/action/0?ti=5661895&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" />
		</noscript>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K8P8BRQ');</script>
		<!-- End Google Tag Manager -->
	</head>
	<body <?php body_class(); ?>>

		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8P8BRQ"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<nav class="navbar navbar-inverse navbar-static-top custom-navbar navbar-fixed-top" role="navigation">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?php echo home_url(); ?>">
		        <span class="navbar-brand-container">
		            <img class="header-logo" src="<?php echo get_template_directory_uri(); ?>/img/mb-logo.svg" alt="MailboxWorks Logo" />
				    <img class="header-mobile-logo" src="<?php echo get_template_directory_uri(); ?>/img/mb-logo-mobile.svg" alt="MailboxWorks Logo" />
		        </span>
		        <span class="tagline hidden-sm hidden-xs">Lowest Prices on Mailboxes, Period.</span>
		      </a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <li>
		          <a href="<?php echo wc_get_cart_url(); ?>" title="Your Shopping Cart" role="button" class="shopping-cart-button">
		              <button><i class="fa fa-shopping-cart"></i> <span class="icon-text  hidden-sm hidden-xs">Cart</span></button>
		          </a>
		        </li>
		    </ul>
		    <div class="collapse navbar-collapse navbar-left" id="navbar">
		       <?php html5blank_nav(); ?>
		    </div><!--/.navbar-collapse -->
		  </div>
		</nav>
		<nav class="navbar navbar-default navbar-static-top contact-navbar">

		    <div class="container">
		        <form class="navbar-right col-xs-12 col-md-5 col-lg-6 form-horizontal search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>" role="search">
		            <div class="form-group">
		                <input type="text" placeholder="Search for Products" name="s" class="form-control">
		            </div>
		            <div class="form-group">
		                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
		            </div>
		        </form>
		        <ul class="nav navbar-nav navbar-left">
		          <li class="contact-phone"><a href="https://www.mailboxworks.com/contact/" title="Contact Us"><i class="fa fa-phone-square"></i> <span class="icon-text"><span id="PhoneNumber1" style="display: none">(866) 717-4943</span></span></a></li>
		          <!-- <li class="contact-chat  hidden-sm hidden-xs"><a href="https://server.iad.liveperson.net/hc/21430514/?cmd=file&file=visitorWantsToChat&site=21430514&byhref=1" title="Chat with Us"><i class="fa fa-comment"></i> <span class="icon-text"><span id="lpButDivID-1383067982973"></span></span></a></li> -->
				  <li class="contact-quote"><a href="/request-a-quote/" title="Request a quote"><i class="fa fa-list"></i> <span class="icon-text"> Request a Quote</a></li>
				  <li class="contact-email hidden-xs"><a href="/contact/" title="Contact Us"><i class="fa fa-envelope"></i> <span class="icon-text">Contact Us</span></a></li>
		        </ul>
		    </div>
		</nav>

		<?php
			if (is_archive()) { ?>
				<div class="container hidden-xs mini-banners">
					<div class="row">
						<div class="col-md-5 col-sm-5 mini-banner coupon-banner">
							<a href="/coupon-form/" title="get a coupon"><img src="<?php echo get_template_directory_uri(); ?>/img/mini-banner_coupon.jpg" alt="Free shipping on orders over $30.00" /></a>
						</div>
						<div class="col-md-7 col-sm-7 mini-banner quote-banner">
							<a href="/request-a-quote/" title="Get a quote"><img src="<?php echo get_template_directory_uri(); ?>/img/mini-banner_quote.jpg" alt="Free shipping on orders over $30.00" /></a>
						</div>
					</div>
				</div>
		<?php } ?>
