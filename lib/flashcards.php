<?php
	
	session_start();
	if(!isset($_SESSION['Level']))
		{
			$_SESSION['Level']=1;
			$_SESSION['Question']=1;
		}
	else if(!isset($_SESSION['Question']))
		{
			$_SESSION['Question']=1;
		}
	else if($_SESSION['Level']>10)
		{
			echo "END";
			unset($_SESSION['Level']);

		}
	
			$level = $_SESSION['Level'];
			$question = $_SESSION['Question'];

			if($question++==1)
				{
					 render_questions($level);
					 $_SESSION['Question']=$question;	
				}
			else if($question>8)
				{
					unset($_SESSION['Question']);
					$level++;
					$_SESSION['Level']=$level;
				}
			else
				{
					$_SESSION['Question']=$question++;		
				}
			
			
		

		function render_questions($level)
			{
				$operators = array('+','-','*','/');
				$range = array(1,15,50,75,105,215,313,450,500,666,766);
				$operator_stack = array();
				$operand_stack_op1 = array();
				$operand_stack_op2 = array();
				$index=0;
				
				while($index++<8)
						array_push($operator_stack,$operators[rand(0,3)]);
				$index = 0;

				while($index<8)
					{
						array_push($operand_stack_op1,rand($range[$level-1],$range[$level]));
						$op=0;
						while(($op>$operand_stack_op1[$index]));
							{
								
								$op=rand($range[$level-1],$range[$level]);
								if($operator_stack[$index]=='/')
								while($operand_stack_op1[$index]%$op!=0)
										$op=rand($range[$level-1],$range[$level]);
							}
						if(($op>$operand_stack_op1[$index])||$op==0)
							continue;
						array_push($operand_stack_op2,$op);
						$index++;
					}
				$question_set = array();
				$index=0;
				while($index<8)
					{
						$question_set[$index]=array();
						$question_set[$index]['op1']= $operand_stack_op1[$index];
						$question_set[$index]['opr']=$operator_stack[$index];
						$question_set[$index]['op2']= $operand_stack_op2[$index];
						$index++;
					}
				echo json_encode($question_set);
			}