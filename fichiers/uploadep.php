<?php

	$nom='retd'.$numdec;

	if (!is_dir("justificatifdep/".$nom)) {

		mkdir("justificatifdep/".$nom);

	}

	if (isset($_FILES['just'] ) ) {

		$value=$_FILES['just'];
		$count=count($value['name']);

		for ($i=0; $i<$count; $i++) {
			

			if ($value['type'][$i] == "application/pdf") {
				$source_file = $value['tmp_name'][$i];
				
				$dest_file = "justificatifdep/".$nom."/".$value['name'][$i];

				if (file_exists($dest_file)) {
					print "Le dossier selctionné existe";

				}else {
					move_uploaded_file( $source_file, $dest_file )
					or die ("Error!!");
				}

			}
		}
	}


	?>
</body>
</html>