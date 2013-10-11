<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/modal.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/jquery.simplemodal-1.4.4.js"></script>
        <?php include('header.php'); include('navigator.php'); ?> 

    </head>
    <body>
        <div class='main-content'>
        <h2>Search Results</h2>        

            <?php 
                            
                //$link = "http://mc.manuscriptcentral.com/LongRequest/ee?TAG_ACTION=DOWNLOAD_PROOF_FILE&DOCUMENT_ID=15181208&FILE_KEY=1166662313&DOWNLOAD=TRUE&FILE_TYPE=DOCUMENT&PROOF_FILE_TYPE=HTML&DOCUMENT_HASHCODE=1924825245&SANITY_CHECK_DOCUMENT_ID=15181208&RANDOM=688";
                //$link = "http://mc.manuscriptcentral.com/LongRequest/ee?TAG_ACTION=DOWNLOAD_PROOF_FILE&DOCUMENT_ID=15193337&FILE_KEY=1167646469&DOWNLOAD=TRUE&FILE_TYPE=DOCUMENT&PROOF_FILE_TYPE=HTML&DOCUMENT_HASHCODE=1243247822&SANITY_CHECK_DOCUMENT_ID=15193337&RANDOM=1235";
                $link = $_POST['searchInput'];
                $html = file_get_contents($link);
                
                $lookforframe = explode("src='",$html);
                $isolatelink = explode("'",$lookforframe[1]);
                $newlink = "http://mc.manuscriptcentral.com/LongRequest/". $isolatelink[0]; 
                
                $gettingThere = explode("href='",file_get_contents($newlink));
                
                for($i = 1; $i < count($gettingThere); $i++){
                    if(strpos($gettingThere[$i],"TAG_ACTION=DOWNLOAD_FILE&DOCUMENT_ID") !== false){
                        //false
                    }else{
                        
                        $almost = explode("'",$gettingThere[$i]);
                        $weAreThere = explode("'",$almost[0]);
                        $finalLink[] = "http://mc.manuscriptcentral.com/LongRequest/".$weAreThere[0];
                    }
                }
                
                
                for($j = 0; $j < count($finalLink); $j++){
                    if(strpos(file_get_contents($finalLink[$j]), "Acknowledgement") !== false){
                        $htmlpaper = file_get_contents($finalLink[$j]);
                    }
                }
                
                
                
                //$almost = explode("'",$gettingThere[2]);
                //$weAreThere = explode("'",$almost[0]);
                //$finalLink = "http://mc.manuscriptcentral.com/LongRequest/".$weAreThere[0];
                
                //$htmlpaper = file_get_contents($finalLink);
				
                $titleStart = strpos($htmlpaper, "<p class=01PaperTitle");          //get pos of first and last tags of the title
                $titleEnd = strpos($htmlpaper, "</p>", $titleStart);
                $taggedTitle = substr($htmlpaper, $titleStart, $titleEnd - $titleStart);   //get title as a substring
                $title = strip_tags($taggedTitle);                              //remove html tagging  
				
				$authorStart = strpos($htmlpaper, "<p class=02PaperAuthors");  
				$authorEnd = strpos($htmlpaper, "</p>", $authorStart);
				$taggedAuthors = substr($htmlpaper, $authorStart, $authorEnd - $authorStart);
				$authors = strip_tags($taggedAuthors);
				
				$abstractStart = strpos($htmlpaper, "<p class=03Abstract");  
				$abstractEnd = strpos($htmlpaper, "</p>", $abstractStart);
				$taggedAbstract = substr($htmlpaper, $abstractStart, $abstractEnd - $abstractStart);
				$abstract = strip_tags($taggedAbstract);
				
				 //echo the paper info
                echo "<div class='searchResults'><h3>Paper found!</h3>
						<strong>Title: </strong><div>".$title."</div><br/>
						<strong>Authors: </strong><div>".$authors."</div><br/>
						<strong>Abstract: </strong><div>".$abstract."</div><br/>";
						
                
                //getting the refs out of the html
                $noOfRefs = substr_count($htmlpaper, "<p class=N3References");
                $taggedRefs = array(); //this is the array containing all of the references details, each ref is 1 string
                
                if($noOfRefs != 0){
                    echo "<strong>Found ". $noOfRefs. " references</strong></div>";
					$refEnd = 0;
                for($i = 0; $i <= $noOfRefs; $i++){
                    $refStart = strpos($htmlpaper, "<p class=N3References", $refEnd);
                    
                    $refEnd = strpos($htmlpaper, "</p>", $refStart);
                
                    $taggedRefs[$i] = substr($htmlpaper, $refStart, $refEnd - $refStart);
                    
                    //echo "<div style='width100%;border-style:solid'><h1>Ref No: ". $i. "</h1><br/>Start: ".$refStart." End: ".$refEnd." Bibliography: ".$taggedRefs[$i]."</div>";                    
                }
                } else{
                    echo "<strong>No references found</strong></div>";
                }
                
                /* 
                 * 
                 * This section gets and displays the entire manuscript as raw and de-tagged for debug/testing purposes
                 *                 
				$leftpane = "<div style='float:left;width:49%;border-style:solid;'><h1>Article</h1>".$htmlpaper."</div>";
                $rightpane = "<div style='float:right;width:49%'><h1>Raw html</h1>".htmlspecialchars($htmlpaper)."</div>";           
                
                echo $leftpane;
                echo $rightpane;
                */
				
                //echo htmlspecialchars(file_get_contents($finalLink))              


				/*
				 *	
				 * Output placeholder
				 *
				 */
				
				$validResults = array(
					0 => array(
						'title' => 'Mystical valid Paper Numero Uno',
						'authors' => 'M. Smith et al.',
						'journal' => 'Energ Environ. Sci.',
						'year' => '2013',
						'volume' => '6',
						'pages' => '666-777',
					),
					1 => array(
						'title' => 'Super valid crazy paper number 2',
						'authors' => 'I. Coates et al.',
						'journal' => 'J. Mat. Chem. A',
						'year' => '1066',
						'volume' => '123',
						'pages' => '456-789',
					),
					2 => array(
						'title' => 'A third ultimate valid paper',
						'authors' => 'J. Bloggs et al.',
						'journal' => 'RSC Horizons',
						'year' => '2015',
						'volume' => '1',
						'pages' => '10000-10001',
					),
					3 => array(
						'title' => 'Paper 4',
						'authors' => 'J. Bloggs et al.',
						'journal' => 'RSC Horizons',
						'year' => '2015',
						'volume' => '1',
						'pages' => '10000-10001',
					),
					4 => array(
						'title' => '5th Paper',
						'authors' => 'J. Bloggs et al.',
						'journal' => 'RSC Horizons',
						'year' => '2015',
						'volume' => '1',
						'pages' => '10000-10001',
					),
				);
				
				$invalidResults = array(
					0 => array(
						'title' => 'Oh no, an invalid paper!',
						'authors' => 'S. C. S. Austin',
						'journal' => 'ACS J. Chem. Shit',
						'year' => '2010',
						'volume' => '199',
						'pages' => '1-8',
					),
				);
				
				//valid results header		
				echo	'<div class="searchResults">
							<h3 id="suggested">Suggested Article Alerts</h3>					
								<label class="selectAll" id="selectAllLabel">
									<input type="checkbox" id="selectAllCheckBox" onClick="toggle(this)" name="selectAll"/>
									Select All</label>
								<input type="submit" id="copyToClipboard" value="Copy to Clipboard"/><br/>';
								
				for($i = 0; $i < count($validResults); $i++){
					//print out results that have not been referenced
					echo 	'<label class="valid" id="label'.$i.'">
								<input type="checkbox" name="result" class="validResult" id="validResult'.$i.'" value="'.$i.'"/>'
									.$validResults[$i]['title'].'<br/>'.$validResults[$i]['authors'].', <i>'.$validResults[$i]['journal'].'</i>, '.$validResults[$i]['year'].', <b>'.$validResults[$i]['volume'].'</b>, '.$validResults[$i]['pages'].'.<br/><br/></label>';
				}
				
				//closing up valid results section
				echo '</div>';
				
				
				//invalid results section
				echo '<div class="searchResults">
						<h3>Already Referenced</h3>';
						
				for($i = 0; $i < count($invalidResults); $i++){
					//print out results that have already been referenced in the input paper
					echo	'<label class="invalid">
								<input type="checkbox" disabled="disabled"/>'
									.$invalidResults[$i]['title'].'<br/>'
									.$invalidResults[$i]['authors'].'<br/>
								<i>'.$invalidResults[$i]['journal'].'</i>, '
									.$invalidResults[$i]['year'].', 
								<b>'.$invalidResults[$i]['volume'].'</b>, '
									.$invalidResults[$i]['pages'].							
								'.</label>';
				}
				
				//closing up invalid results section
				echo '</div>';
				
            ?> 
		<script language="JavaScript">
			$( document ).ready(function() {
				var noOfSuggested = $(".validResult").size();
				$('#suggested').html(noOfSuggested + " Suggested Article Alerts");
			});
			
			//for the 'Select All' button
			$('#selectAllLabel').click(toggle('#selectAllCheckBox'));		

			function toggle(source) {
				checkboxes = document.getElementsByName('result');
				for(var i=0, n=checkboxes.length;i<n;i++) {
					checkboxes[i].checked = source.checked;
				}
			}

			//for the Copy to Clipboard Button
			$('#copyToClipboard').click(function(){
				var noOfSuggested = $(".validResult").size();
				var checked = $(".validResult:checked").size();											
				
				if(checked == 0){
					//if no suggestions are selected
					$('#basic-modal-content').html('<h2 class="error">No results selected</h2>');
				} else{
					//if some suggestions are selected
					var content = "";
					for(var i = 0; i <= noOfSuggested; i++){
						if($('#validResult' + i).is(':checked')){
							content = content + $('#label' + i).html();								
						}					
					}		
						
					$.get('files/AASetText.html', function(data){
						setText = data;
					});		
					$('#basic-modal-content').html('<h1>Copy this text:</h1><div id="inner-modal-content">' + setText + strip_tags(content, '<br><i><b>')+ '</div>');			
				}
				
				$('#basic-modal-content').modal();
			});				
			
			
			function strip_tags (input, allowed) {

				allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
				var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
				commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
				return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
					return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
				});
			}

			</script>	
			<div id="basic-modal-content"></div>			
		</div>
    </body>
</html>