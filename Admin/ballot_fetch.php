<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	// Fetch all positions to use later for checking priority limits
	$sql = "SELECT * FROM positions";
	$pquery = $conn->query($sql);

	$output = '';
	$candidate = '';

	// Select all positions ordered by priority
	$sql = "SELECT * FROM positions ORDER BY priority ASC";
	$query = $conn->query($sql);
	$num = 1;
	while($row = $query->fetch_assoc()){
		// Determine if multiple votes are allowed for the position
		$input = ($row['max_vote'] > 1) ? 
            '<input type="checkbox" class="flat-red '.slugify($row['position_name']).'" name="'.slugify($row['position_name'])."[]".'">' : 
            '<input type="radio" class="flat-red '.slugify($row['position_name']).'" name="'.slugify($row['position_name']).'">';

		// Fetch candidates for the current position
		$sql = "SELECT * FROM candidates WHERE position_id='".$row['position_id']."'";
		$cquery = $conn->query($sql);
		while($crow = $cquery->fetch_assoc()){
			$image = (!empty($crow['photo'])) ? '../images/'.$crow['photo'] : '../images/profile.jpg';
			$candidate .= '
				<li>
					'.$input.'<button class="btn btn-primary btn-sm btn-flat clist"><i class="fa fa-search"></i> Platform</button>
                    <img src="'.$image.'" height="100px" width="100px" class="clist">
                    <span class="cname clist">'.$crow['firstname'].' '.$crow['lastname'].'</span>
				</li>
			';
		}

		// Display instructions based on whether multiple votes are allowed
		$instruct = ($row['max_vote'] > 1) ? 'You may select up to '.$row['max_vote'].' candidates' : 'Select only one candidate';
		
		// Disable move-up button if the position is already at the top
		$updisable = ($row['priority'] == 1) ? 'disabled' : '';
		// Disable move-down button if the position is already at the bottom
		$downdisable = ($row['priority'] == $pquery->num_rows) ? 'disabled' : '';

		// Add HTML structure for the position and its candidates
		$output .= '
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-solid" id="'.$row['position_id'].'">
						<div class="box-header with-border">
							<h3 class="box-title"><b>'.$row['position_name'].'</b></h3>
							<div class="pull-right box-tools">
				                <button type="button" class="btn btn-default btn-sm moveup" data-id="'.$row['position_id'].'" '.$updisable.'><i class="fa fa-arrow-up"></i></button>
				                <button type="button" class="btn btn-default btn-sm movedown" data-id="'.$row['position_id'].'" '.$downdisable.'><i class="fa fa-arrow-down"></i></button>
				            </div>
						</div>
						<div class="box-body">
							<p>'.$instruct.'
								<span class="pull-right">
									<button type="button" class="btn btn-success btn-sm btn-flat reset" data-desc="'.slugify($row['position_name']).'"><i class="fa fa-refresh"></i> Reset</button>
								</span>
							</p>
							<div id="candidate_list">
								<ul>
									'.$candidate.'
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		';

		// Update the priority in the database
		$sql = "UPDATE positions SET priority = '$num' WHERE position_id = '".$row['position_id']."'";
		$conn->query($sql);

		$num++;
		$candidate = '';  // Reset the candidate list for the next position
	}

	echo json_encode($output);

?>
