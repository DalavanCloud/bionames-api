<?php

// mockup template

// do PHP stuff here to get query parameters...
$id = $_GET['id'];


?>
<!DOCTYPE html>
<html>
<head>
	<base href="/bionames-api/" />
	<title>Title</title>
	
	<!-- standard stuff -->
	<meta charset="utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">	
	
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- documentcloud -->
	<!--[if (!IE)|(gte IE 8)]><!-->
	<link href="public/assets/viewer-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="public/assets/plain-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link href="public/assets/viewer.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="public/assets/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<![endif]-->
	
	<script src="public/assets/viewer.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/assets/templates.js" type="text/javascript" charset="utf-8"></script>			    
	
</head>
<body onload="$(window).resize()">

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
	 <a class="brand" href="mockup_index.php">BioNames</a>
	 <ul class="nav">
	  <li><form class="navbar-search pull-left" method="get" action="mockup_search.php">
		<input type="text" id='q' name='q' data-provide="typeahead" class="search-query" placeholder="Search" autocomplete="off" value="<?php echo $q; ?>">
		</form> 
	  </li>
	  <li><a href="#">More...</a></li>
	  </ul>
	</div>
</div>
	
<div style="margin-top:42px;padding:0px;" class="container-fluid">
	<div class="row-fluid">
		<div class="span8">
			<div id="doc">Loading...</div>
		</div>
		<div class="span4" id="metadata">
		</div>
	</div>
</div>


<script type="text/javascript">
	var id = "<?php echo $id;?>";
	
	var windowWidth = $(window).width();
	var windowHeight =$(window).height();
	
	// Display an object
	function display_publication (id)
	{
		$.getJSON("http://bionames.org/bionames-api/id/" + id + "?callback=?",
			function(data){
				if (data.status == 200)
				{
					var html = '';
					
					html += '<div class="pub">';
					
					if (data.thumbnail)
					{
						html += '<div ><img style="border:1px solid rgb(128,128,128);" src="' + data.thumbnail + '" width="100" /></div>';
					}					
					
					if (data.title)
					{
						html += '<div class="title">' + data.title + '</div>';
						document.title = data.title;
						
						$('#title').html(data.title);
					}
										
					html += '<div class="meta">';
					
					
					html += '<div>';
					if (data.author)
					{
						html += 'by ';
						for (var j in data.author)
						{
							html += '<a href="mockup_author.php?name=' + data.author[j].name + '">';
							html += data.author[j].name + ' ';
							html += '</a>';
							html += '; ';
						}
					}
					html += '</div>';
					
					html += '<div>';
					if (data.journal)
					{
						if (data.journal.name)
						{
							html += '<span class="journal">';
							
							// Do we have an ISSN?
							var issn = '';
							var oclc = '';
							if (data.journal.identifier)
							{
								for (var j in data.journal.identifier)
								{
									switch (data.journal.identifier[j].type)
									{
										case 'issn':
											issn = data.journal.identifier[j].id;
											break;

										case 'oclc':
											oclc = data.journal.identifier[j].id;
											break;
											
										default:
											break;
									}
								}
							}
							
							if (issn != '')
							{
								html += '<a href="mockup_journal.php?issn=' + issn + '">';
							}
							else
							{
								if (oclc != '') {
								html += '<a href="mockup_journal.php?oclc=' + oclc + '">';
								} else {								
									html += '<a href="mockup_journal.php?journal=' + data.journal.name + '">';	
								}
							}
							html += data.journal.name;
							
							html += '</a>';
							
							html += '</span>';
						}
						if (data.journal.volume)
						{
							html += ' ' + data.journal.volume;
						}
						if (data.journal.pages)
						{
							html += ' pages ' + data.journal.pages;
						}
					}
					html += '</div>';
					
					if (data.identifier)
					{
						html += '<ul>';
						for (var j in data.identifier)
						{
							switch (data.identifier[j].type)
							{
								case "ark":
									html += "<li><a href=\"http://gallica.bnf.fr/ark:/" + data.identifier[j].id + "\" target=\"_new\">ark:/" + data.identifier[j].id + "</a></li>";
									break;

								case "biostor":
									html += "<li><a href=\"http://biostor.org/reference/" + data.identifier[j].id + "\" target=\"_new\">biostor.org/reference/" + data.identifier[j].id + "</a></li>";
									break;

								case "cinii":
									html += "<li><a href=\"http://ci.nii.ac.jp/naid/" + data.identifier[j].id + "\" target=\"_new\">ci.nii.ac.jp/naid/" + data.identifier[j].id + "</a></li>";
									break;
									
								case "doi":
									html += "<li><a href=\"http://dx.doi.org/" + data.identifier[j].id + "\" target=\"_new\">dx.doi.org/" + data.identifier[j].id + "</a></li>";
									break;

								case "handle":
									html += "<li><a href=\"http://hdl.handle.net/" + data.identifier[j].id + "\" target=\"_new\">hdl.handle.net/" + data.identifier[j].id + "</a></li>";
									break;

								case "jstor":
									html += "<li><a href=\"http://www.jstor.org/stable" + data.identifier[j].id + "\" target=\"_new\">www.jstor.org/stable/" + data.identifier[j].id + "</a></li>";
									break;
									
								default:
									break;
							}
						}	
						html += '</ul>';
					}
					

					html += '</div>';
					
					$("#metadata").html(html);
					
					// Display document viewer if we have a document
					var docUrl = '';					
					if (data.identifier)
					{
						for (var j in data.identifier)
						{
							//console.log(data.identifier[j].type);
							switch (data.identifier[j].type)
							{
								case "ark":
									// ark:/12148/bpt6k61536173/f400
									
									var ark_pattern = /(.*)\/(.*)\/f(\d+)/;
									var ark = data.identifier[j].id;
									//console.log(ark);
									var match = ark.match(ark_pattern);
									docUrl = 'http://bionames.org/bionames-gallica/documentcloud/' + match[2] + 'f' + match[3] + '.json';
									break;
							
								case "biostor":
									docUrl = 'http://biostor.org/dv/' + data.identifier[j].id + '.json';
									break;
																		
								default:
									break;
							}
						}
					}
					
					
					
					html += '</div>';
					
					if (docUrl == '')
					{
						if (data.file)
						{
							if (data.file.sha1)
							{
								docUrl = 'http://bionames.org/bionames-archive/documentcloud/' + data.file.sha1 + '.json';
							}
						}
					
					}
					
					console.log(docUrl);
					
					if (docUrl != '')
					{
						DV.load(docUrl, {
							container: '#doc',
							/*width:windowWidth,*/
							width:700,
							height:windowHeight - 40,
							/* height:windowHeight, */
							sidebar: false
						});	
					}
					else
					{
						if (data.thumbnail)
						{
							var html = '';
							html += '<div style="text-align:center;">';
							html += '<div class="alert">';
							html += '<strong>Limited access!</strong> You may need a subscription to access this item.';
							html += '</div>';
							html += '<img style="border:1px solid rgb(128,128,128);padding:10px;" src="' + data.thumbnail + '" width="400" />';
							html += '</div>';
							$('#doc').html(html);
						}
						else
						{
							var html = '';
							html += '<div style="text-align:center;">';
							html += '<div class="alert">';
							html += 'Unable to display this item.';
							html += '</div>';
							html += '</div>';
							
							$('#doc').html(html);
						}
					}
				}
			});
	}
	
	function display_publication_names (id)
	{
		$.getJSON("http://bionames.org/bionames-api/publication/" + id + "/names?callback=?",
			function(data){
				if (data.status == 200)
				{
					var html = '';
					
					html += '<ul>';
					for (var i in data.names) {
						html += '<li>';
						html += '<a href="mockup_taxon_name.php?id=' + data.names[i].cluster + '">';
						html += data.names[i].nameComplete;
						html += '</a>';
						html += '<br/>';
						html += '<span style="color:rgb(128,128,128);font-size:70%">' + data.names[i].id + '</span>';						
						html += '</li>';
					}
					html += '</ul>';
					
					$('#names').html(html);
				}
			});
	}
					
					
	$("#metadata").html("Object &quot;" + id + "&quot; not found");
		
	display_publication(id);
	display_publication_names(id);

	// http://stackoverflow.com/questions/6762564/setting-div-width-according-to-the-screen-size-of-user
	$(window).resize(function() { 
		var windowWidth = 700;
//		var windowHeight =$(window).height();
		var windowHeight =$(window).height() - 40;
		
		console.log('width=' + $(window).width());
		console.log('height=' + $(window).height());
		console.log(windowHeight);
		
		$('#doc').css({'height':windowHeight });
	});
	

	<!-- typeahead for search box -->
	$("#q").typeahead({
	  source: function (query, process) {
		$.getJSON('http://bionames.org/bionames-api/name/' + query + '/suggestions?callback=?', 
		function (data) {
		  //data = ['Plecopt', 'Peas'];
		  
		  var suggestions = data.suggestions;
		  process(suggestions)
		})
	  }
	})
	
</script>

</body>
</html>