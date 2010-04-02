<?php
		
	//write new values into the text files
	if (isset($_POST['submit'])) {
		
		//get new slide 1 text field values
		$slide1_1_text = $_POST['slide1_1'];
		$slide1_2_text = $_POST['slide1_2'];
		$slide1_3_text = $_POST['slide1_3'];
		$slide1_4_text = $_POST['slide1_4'];
		$slide1_5_text = $_POST['slide1_5'];
		$slide1_6_text = $_POST['slide1_6'];
		
		//get new slide 2 text field values
		$slide2_1_text = $_POST['slide2_1'];
		$slide2_2_text = $_POST['slide2_2'];
		$slide2_3_text = $_POST['slide2_3'];
		$slide2_4_text = $_POST['slide2_4'];
		$slide2_5_text = $_POST['slide2_5'];
		
		//get new slide 3 text field value
		$slide3_text = $_POST['slide3'];
		
		//write to text file for slide 1 text field 1
		$slide1_1 = "slide1_1.txt";
		$fwh1_1 = fopen($slide1_1, 'w') or die("Error opening slide 1 text field 1");
		$slide1_1_line1 = "myVariable= ";
		fwrite($fwh1_1, $slide1_1_line1);
		$slide1_1_data = $slide1_1_text;
		fwrite($fwh1_1, $slide1_1_data);
		fclose($fwh1_1);
			
			//write to text file for slide 1 text field 1
			$slide1_2 = "slide1_2.txt";
			$fwh1_2 = fopen($slide1_2, 'w') or die("Error opening slide 1 text field 2");
			$slide1_2_line1 = "myVariable= ";
			fwrite($fwh1_2, $slide1_2_line1);
			$slide1_2_data = $slide1_2_text;
			fwrite($fwh1_2, $slide1_2_data);
			fclose($fwh1_2);
			
				//write to text file for slide 1 text field 1
				$slide1_3 = "slide1_3.txt";
				$fwh1_3 = fopen($slide1_3, 'w') or die("Error opening slide 1 text field 3");
				$slide1_3_line1 = "myVariable= ";
				fwrite($fwh1_3, $slide1_3_line1);
				$slide1_3_data = $slide1_3_text;
				fwrite($fwh1_3, $slide1_3_data);
				fclose($fwh1_3);
				
					//write to text file for slide 1 text field 4
					$slide1_4 = "slide1_4.txt";
					$fwh1_4 = fopen($slide1_4, 'w') or die("Error opening slide 1 text field 4");
					$slide1_4_line1 = "myVariable= ";
					fwrite($fwh1_4, $slide1_4_line1);
					$slide1_4_data = $slide1_4_text;
					fwrite($fwh1_4, $slide1_4_data);
					fclose($fwh1_4);
					
						//write to text file for slide 1 text field 5
						$slide1_5 = "slide1_5.txt";
						$fwh1_5 = fopen($slide1_5, 'w') or die("Error opening slide 1 text field 5");
						$slide1_5_line1 = "myVariable= ";
						fwrite($fwh1_5, $slide1_5_line1);
						$slide1_5_data = $slide1_5_text;
						fwrite($fwh1_5, $slide1_5_data);
						fclose($fwh1_5);
						
							//write to text file for slide 1 text field 6
							$slide1_6 = "slide1_6.txt";
							$fwh1_6 = fopen($slide1_6, 'w') or die("Error opening slide 1 text field 6");
							$slide1_6_line1 = "myVariable= ";
							fwrite($fwh1_6, $slide1_6_line1);
							$slide1_6_data = $slide1_6_text;
							fwrite($fwh1_6, $slide1_6_data);
							fclose($fwh1_6);
				
		//write to text file for slide 2 text field 1
		$slide2_1 = "slide2_1.txt";
		$fwh2_1 = fopen($slide2_1, 'w') or die("Error opening slide 2 text field 1");
		$slide2_1_line1 = "myVariable= ";
		fwrite($fwh2_1, $slide2_1_line1);
		$slide2_1_data = $slide2_1_text;
		fwrite($fwh2_1, $slide2_1_data);
		fclose($fwh2_1);
			
			//write to text file for slide 2 text field 2
			$slide2_2 = "slide2_2.txt";
			$fwh2_2 = fopen($slide2_2, 'w') or die("Error opening slide 2 text field 2");
			$slide2_2_line1 = "myVariable= ";
			fwrite($fwh2_2, $slide2_2_line1);
			$slide2_2_data = $slide2_2_text;
			fwrite($fwh2_2, $slide2_2_data);
			fclose($fwh2_2);
			
				//write to text file for slide 2 text field 3
				$slide2_3 = "slide2_3.txt";
				$fwh2_3 = fopen($slide2_3, 'w') or die("Error opening slide 2 text field 3");
				$slide2_3_line1 = "myVariable= ";
				fwrite($fwh2_3, $slide2_3_line1);
				$slide2_3_data = $slide2_3_text;
				fwrite($fwh2_3, $slide2_3_data);
				fclose($fwh2_3);
				
					//write to text file for slide 2 text field 4
					$slide2_4 = "slide2_4.txt";
					$fwh2_4 = fopen($slide2_4, 'w') or die("Error opening slide 2 text field 4");
					$slide2_4_line1 = "myVariable= ";
					fwrite($fwh2_4, $slide2_4_line1);
					$slide2_4_data = $slide2_4_text;
					fwrite($fwh2_4, $slide2_4_data);
					fclose($fwh2_4);
				
						//write to text file for slide 2 text field 5
						$slide2_5 = "slide2_5.txt";
						$fwh2_5 = fopen($slide2_5, 'w') or die("Error opening slide 2 text field 5");
						$slide2_5_line1 = "myVariable= ";
						fwrite($fwh2_5, $slide2_5_line1);
						$slide2_5_data = $slide2_5_text;
						fwrite($fwh2_5, $slide2_5_data);
						fclose($fwh2_5);
				
		//write to text file for slide 3
		$slide3 = "slide3.txt";
		$fwh3 = fopen($slide3, 'w') or die("Error opening slide 3");
		$slide3_line1 = "myVariable= ";
		fwrite($fwh3, $slide3_line1);
		$slide3_data = $slide3_text;
		fwrite($fwh3, $slide3_data);
		fclose($fwh3);
		
		function displaySuccess() {
			echo "<h2>Slideshow Successfully Updated</h2>";
		}
	}
		
		//create file handles to get text from files to prepopulate text fields with text that is already in the slideshow
		
		//open slide 1 text field 1
		$slide1_1 = "slide1_1.txt";
		$fh1_1 = fopen($slide1_1, 'r');
		
			//open slide 1 text field 2
			$slide1_2 = "slide1_2.txt";
			$fh1_2 = fopen($slide1_2, 'r');
		
				//open slide 1 text field 3
				$slide1_3 = "slide1_3.txt";
				$fh1_3 = fopen($slide1_3, 'r');
				
					//open slide 1 text field 4
					$slide1_4 = "slide1_4.txt";
					$fh1_4 = fopen($slide1_4, 'r');
				
						//open slide 1 text field 5
						$slide1_5 = "slide1_5.txt";
						$fh1_5 = fopen($slide1_5, 'r');
						
							//open slide 1 text field 6
							$slide1_6 = "slide1_6.txt";
							$fh1_6 = fopen($slide1_6, 'r');
				
		//open slide 2 text field 1
		$slide2_1 = "slide2_1.txt";
		$fh2_1 = fopen($slide2_1, 'r');
		
			//open slide 2 text field 2
			$slide2_2 = "slide2_2.txt";
			$fh2_2 = fopen($slide2_2, 'r');
		
				//open slide 2 text field 3
				$slide2_3 = "slide2_3.txt";
				$fh2_3 = fopen($slide2_3, 'r');
					
					//open slide 2 text field 2
					$slide2_4 = "slide2_4.txt";
					$fh2_4 = fopen($slide2_4, 'r');
				
						//open slide 2 text field 5
						$slide2_5 = "slide2_5.txt";
						$fh2_5 = fopen($slide2_5, 'r');
					
		//open slide 3
		$slide3 = "slide3.txt";
		$fh3 = fopen($slide3, 'r');
		
		//read the data from the files
		$read_slide1_1 = fread($fh1_1, filesize($slide1_1));
		fclose($fh1_1);
		
			$read_slide1_2 = fread($fh1_2, filesize($slide1_2));
			fclose($fh1_2);
		
				$read_slide1_3 = fread($fh1_3, filesize($slide1_3));
				fclose($fh1_3);
				
					$read_slide1_4 = fread($fh1_4, filesize($slide1_4));
					fclose($fh1_4);
					
						$read_slide1_5 = fread($fh1_5, filesize($slide1_5));
						fclose($fh1_5);
					
							$read_slide1_6 = fread($fh1_6, filesize($slide1_6));
							fclose($fh1_6);
					
				$read_slide2_1 = fread($fh2_1, filesize($slide2_1));
				fclose($fh2_1);
						
					$read_slide2_2 = fread($fh2_2, filesize($slide2_2));
					fclose($fh2_2);
				
						$read_slide2_3 = fread($fh2_3, filesize($slide2_3));
						fclose($fh2_3);
						
							$read_slide2_4 = fread($fh2_4, filesize($slide2_4));
							fclose($fh2_4);
						
								$read_slide2_5 = fread($fh2_5, filesize($slide2_5));
								fclose($fh2_5);
						
			$read_slide3 = fread($fh3, filesize($slide3));
			fclose($fh3);
			
		
		//prevent myVariable text from being rewritten or displayed in the textfields
		$str2replace = "myVariable= ";
		$n = "";
		
		$display1_1 = str_replace($str2replace, $n, $read_slide1_1);
		
			$display1_2 = str_replace($str2replace, $n, $read_slide1_2);
			
				$display1_3 = str_replace($str2replace, $n, $read_slide1_3);
				
					$display1_4 = str_replace($str2replace, $n, $read_slide1_4);
					
						$display1_5 = str_replace($str2replace, $n, $read_slide1_5);
						
							$display1_6 = str_replace($str2replace, $n, $read_slide1_6);
				
		$display2_1 = str_replace($str2replace, $n, $read_slide2_1);
			
			$display2_2 = str_replace($str2replace, $n, $read_slide2_2);
			
				$display2_3 = str_replace($str2replace, $n, $read_slide2_3);
				
					$display2_4 = str_replace($str2replace, $n, $read_slide2_4);
					
						$display2_5 = str_replace($str2replace, $n, $read_slide2_5);
				
		$display3 = str_replace($str2replace, $n, $read_slide3);
	
?>