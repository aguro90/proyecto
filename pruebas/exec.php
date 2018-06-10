		<?php	
$command = escapeshellcmd('twitter.py');
$output = shell_exec($command);
echo $output;
				?>