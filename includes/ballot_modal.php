<!-- Preview -->
<div class="modal fade" id="preview_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Vote Preview</h4>
            </div>
            <div class="modal-body">
              <div id="preview_body">
                <?php
                  // Assuming a session is set with the voter's ID
                  $voter_id = $_SESSION['voter_id'];  
                  // Fetch all votes of the voter
                  $sql = "SELECT p.position_name, c.candidate_name, c.party 
                          FROM votes v 
                          JOIN candidates c ON v.candidate_id = c.candidate_id
                          JOIN positions p ON c.position_id = p.position_id
                          WHERE v.voter_id = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param('i', $voter_id);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  // Display vote preview for the voter
                  while ($row = $result->fetch_assoc()) {
                    echo "<div class='row votelist'>
                            <span class='col-sm-4'><b>{$row['position_name']}:</b></span> 
                            <span class='col-sm-8'>{$row['candidate_name']} ({$row['party']})</span>
                          </div>";
                  }
                ?>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> Close
              </button>
            </div>
        </div>
    </div>
</div>

<!-- Platform -->
<div class="modal fade" id="platform">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="candidate"></b></h4>
            </div>
            <div class="modal-body">
              <p id="plat_view">
                <?php
                  // Fetch the platform/manifesto for the selected candidate
                  $candidate_id = $_GET['candidate_id'];  // Assuming candidate ID is passed via GET
                  $sql = "SELECT platform FROM candidates WHERE candidate_id = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param('i', $candidate_id);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($row = $result->fetch_assoc()) {
                    echo $row['platform'];
                  } else {
                    echo "Platform information not available.";
                  }
                ?>
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> Close
              </button>
            </div>
        </div>
    </div>
</div>

<!-- View Ballot -->
<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Your Votes</h4>
            </div>
            <div class="modal-body">
              <?php
                $voter_id = $_SESSION['voter_id']; // Assuming session stores the voter ID
                $sql = "SELECT p.position_name, c.firstname AS canfirst, c.lastname AS canlast 
                        FROM votes v 
                        LEFT JOIN candidates c ON c.candidate_id = v.candidate_id
                        LEFT JOIN positions p ON p.position_id = c.position_id 
                        WHERE v.voter_id = ? 
                        ORDER BY p.priority ASC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $voter_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()){
                  echo "
                    <div class='row votelist'>
                      <span class='col-sm-4'><span class='pull-right'><b>{$row['position_name']}:</b></span></span> 
                      <span class='col-sm-8'>{$row['canfirst']} {$row['canlast']}</span>
                    </div>
                  ";
                }
              ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                <i class="fa fa-close"></i> Close
              </button>
            </div>
        </div>
    </div>
</div>
