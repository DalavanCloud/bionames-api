<?php

$q='';
if (isset($_GET['q']))
{
	$q = trim($_GET['q']);
}

?>
<!DOCTYPE html>
<html>
<head>
	<base href="/bionames-api/" />
	<title>Search</title>
	
	<!-- standard stuff -->
	<meta charset="utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">	

	<link href="snippet.css" rel="stylesheet">	

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
	<script src="js/snippet.js"></script>
    

</head>
<body>
	
	<form class="navbar-search pull-left" method="get" action="ms.php">
	<input type="text" id='q' name='q' data-provide="typeahead" data-minLength="3" class="search-query" placeholder="Search" autocomplete="off" value="<?php echo $q; ?>">
	<input type="submit" value="Search">
	</form>      


<div id="didyoumean"></div>
<div id="results"><div>


<<<<<<< HEAD
	foreach ($facet_key_order as $facet)
	{
		if (isset($results->facets[$facet]))
		{
			
			switch ($facet)
			{
				case 'nameCluster':
					echo '<div class="facet names">';
					echo '<h2>Names</h2>';
					break;
					
				case 'taxonConcept':
					echo '<div class="facet taxa">';
					echo '<h2>Taxa</h2>';
					break;
					
				case 'article':
					echo '<div class="facet articles">';
					echo '<h2>Articles</h2>';
					break;
					
				case 'book':
				case 'chapter':
				case 'generic':
					echo '<div class="facet publications">';
					echo '<h2>Publications</h2>';
					break;
				
				default:
					echo '[unknown] facet "' . $facet . '"';
					break;
			}
		
			
			
			$hits = $results->facets[$facet];
			
			foreach ($hits as $id => $value)
			{
				$ids[] =  $id;
	//			echo '<div style="padding-bottom:20px;padding-left:20px;">';
	//			echo '<div style="float:right;border:1px solid rgb(228,228,228);width:16px;font-size:100%;text-align:center;">»</div>';
	
				//echo '<div style="float:right;">';
				// echo '<div style="float:left;">';
			
				switch ($facet)
				{
					case 'nameCluster':
						echo '<div class="name-cluster snippet-wrapper">';
						echo '<a href="mockup_taxon_name.php?id=' . $id . '">';
						echo $value->term;
						echo '</a>';					
						//echo ' [' . $value->count . ']';
						echo '</div>';
						break;
						
					case 'taxonConcept':
						if (1)
						{
							echo '<div id="id' . str_replace("/", "_", $id) . '" class="snippet-wrapper"></div>';
						}
						else
						{
							echo '<a href="mockup_concept.php?id=' . $id . '">';
							echo $value->term ;
							echo '</a>';
							echo ' [' . $value->count . ']';
						}
						break;
	
					case 'article':
					case 'book':
					case 'chapter':
					case 'generic':
						if (1)
						{
							echo '<div id="id' . str_replace("/", "_", $id) . '" class="snippet-wrapper"></div>';
=======
	<script>
		function search(q) {
		
			$.getJSON("http://bionames.org/bionames-api/search/" + encodeURIComponent(q) + "?callback=?",
				function(data){
					if (data.status == 200)
					{		
						var html = '';
						
						if (data.results) {
							var ids=[];
							
							// order in which we want to display facets
							var facet_key_order = [
								'nameCluster',
								'taxonConcept',
								'article',
								'book',
								'chapter',
								'generic'
								];		
							
							for (var facet in facet_key_order) {
								console.log(facet_key_order[facet]);
								
								//console.log(data.results.facets[facet_key_order[facet]]);
								
							//}
							//for (var facet in data.results.facets) {
								if (data.results.facets[facet_key_order[facet]]) {
								
								switch(facet_key_order[facet]) {
									case 'nameCluster':
										html += '<div style="background-color:green;color:white;">Names</div>';
										break;
									case 'taxonConcept':
										html += '<div style="background-color:green;color:white;">Taxa</div>';
										break;
									case 'article':
										html += '<div style="background-color:green;color:white;">Article</div>';
										break;
									case 'book':
									case 'chapter':
									case 'generic':
										html += '<div style="background-color:green;color:white;">Publication</div>';
										break;
									default:
										html += '<div style="background-color:green;color:white;">Unknown facet</div>';
										break;
								}
								
								// output
								html += '<div>';
								for (var hit in data.results.facets[facet_key_order[facet]]) {
									var id = hit;
									ids.push(id);
									id = hit.replace(/\//, '_');
									
									html += '<div style="float:left;">';
									
									switch(facet_key_order[facet]) {
										case 'nameCluster':
											html += '<div>' + data.results.facets[facet_key_order[facet]][hit].term + '</div>';
											break;
										default:
											html += '<div id="id' + id + '">' + id + '</div>';
											break;
									}
									
									html += '</div>';
								}							
								html += '<div style="clear:both;">';
								html += '</div>';
								
								
								// end of facet
								html += '</div>';
								}
							}
>>>>>>> Many changes, some small, some not so
						}
						
						// display details
						for (var id in ids) {
							html += '<script>display_snippets("' + ids[id] + '");<\/script>';
						}
						
						
<<<<<<< HEAD
					default:
						echo '[unknown]';
						break;
				}				
			}
=======
						$('#results').html(html);
					}
				
				
				});
>>>>>>> Many changes, some small, some not so
		}
	
	
		function did_you_mean(name)
		{
			$("#didyoumean").html("");
			
			$.getJSON("http://bionames.org/bionames-api/name/" + encodeURIComponent(name) + "/didyoumean?callback=?",
				function(data){
					if (data.status == 200)
					{		
						var html = '';
						if (data.names.length > 0) {
							html += '<b>Did you mean:</b>';
							html += '<ul>';
							
							for (var i in data.names) {
								html += '<li>';
								html += '<a href="mockup_search.php?q=' + encodeURIComponent(data.names[i]) + '">' + data.names[i] + '</a>';
								html += '</li>';
							}
							html += '</ul>';
							
							$("#didyoumean").html(html);
						}
					}
				});
		}
	</script>


<?php
	echo '<script>
		search(\'' . addcslashes($q, "'") . '\');
		did_you_mean(\'' . addcslashes($q, "'") . '\');
	</script>';
?>	
	
	
	<!-- typeahead for search box -->
	<script>
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
