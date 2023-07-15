<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION["id"];
?>
<!doctype html>
<html lang="en">
<head>
  <title>Music</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="scss/style.css">

</head>
<body>

<body>
  <nav class="navbar navbar-light border-bottom mb-md-5 mb-4">
    <div class="container-fluid justify-content-between align-items-center d-flex">
      <a class="navbar-brand" href="#">
        Songs Management Sytem
      </a>
      <a class="btn btn-sm btn-outline-success" href="backend/logout.php">Logout</a>
    </div>
  </nav>

  <section class="sqi-music-table">
    <div class="container">
      <div class="row bg-light">
        <div class="col-lg-8">
        <form method="POST" action="backend/upload-songs.php" enctype="multipart/form-data">
        <div class="col-lg-8">
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Song">Upload Songs:</label>
            <input type="file" name="songsFile" id="songsFile" class="form-control" required>
          </div>
        </div>
        <div class="col-lg-4">
            <input type="submit" class="btn btn-sm btn-outline-success" value="Upload">
        </div>
        </form>
        </div>
        
        <div class="col-lg-4">
          <div class="form-group has-search mt-3">
            <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#addModel">
              Add New Song
            </button>
          </div>
        </div>
      </div>

    <form action="index.php" method="GET">
      <div class="row bg-light">
        <div class="col-lg-3">
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Song">Song:</label>
            <span class="fa fa-search form-control-feedback"></span>
            <input type="search" placeholder="Song search" value="<?php echo $_GET['search']['title'] ?>" name="title" class="form-control">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Artist">Artist:</label>
            <span class="fa fa-search form-control-feedback"></span>
            <input type="search" placeholder="Artist search" value="<?php echo $_GET['search']['artist'] ?>" name="artist" class="form-control">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Genre">Genre:</label>
            <span class="fa fa-search form-control-feedback"></span>
            <input type="search" placeholder="Genre search" value="<?php echo $_GET['search']['genre'] ?>" name="genre" class="form-control">
          </div>
        </div>
        <div class="col-lg-3 d-flex align-items-end justify-content-end">
          <div class="form-group">
            <button class="btn btn-sm btn-outline-success" type="submit">
              search<i class="fa fa-add"></i>
            </button>
          </div>
        </div>
      </div>
    </form>


      <div class="row bg-light">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" width="100%">
            <thead class="bg-light">
            <tr>
              <th> No. </th>
              <th>Title</th>
              <th>Artist</th>
              <th>Genre</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
              $songs = isset($_GET['songs']) ? $_GET['songs'] : [];
              $i = 1;
              // Display the songs
              foreach($songs as $song) { $i++ ?>
              
            <tr>
              <td><?php echo $i ?></td>
              <td><?php echo $song['title'] ?></td>
              <td><?php echo $song['artist'] ?></td>
              <td><?php echo $song['genre'] ?></td>
              <td>
                <button class="del-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModel">
                  <i class="fa fa-edit" data-id="<?php echo $song['id'] ?>"></i>
                </button>
              </td>
              <td align="left">
                <button class="del-btn" type="button" data-bs-toggle="modal" data-bs-target="#delModel">
                  <i class="fa fa-remove" data-id="<?php echo $song['id'] ?>"></i>
                </button>
              </td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

<!-- Modal -->
<div class="modal fade" id="delModel" tabindex="-1" aria-labelledby="delModelLabelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          Are you sure you want to delete?
        </p>
      </div>
      <form action="backend/delete-song.php" method="POST">
      <div class="modal-footer border-0">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="songId" id="deletedSongID"> 
        <button type="submit" id="confirmDeleteBtn" class="btn btn-sm btn-outline-success">Yes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModelLabelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="m-0">
          Edit
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="backend/update-song.php" method="POST">
      <div class="modal-body">
        <div>
          <div class="form-group has-search mt-3">
            <input type="hidden" id="songId" name="id">
            <input type="hidden" name="_method" value="PUT">
            <label class="form-control-placeholder" for="Song">Song:</label>
            <input type="text" placeholder="Song Name" name="title" id="title" class="form-control">
          </div>
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Artist">Artist:</label>
            <input type="text" placeholder="Artist Name" name="artist" id="artist" class="form-control">
          </div>
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Genre">Genre:</label>
            <input type="text" placeholder="Genre" name="genre" id="genre" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer modal-footer border-0">
        <button type="submit" class="btn btn-sm btn-outline-success">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="addModel" tabindex="-1" aria-labelledby="addModelLabelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="m-0">
          Add New Song
        </h5>
        <button type="button" class="btn-close  " data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="backend/add-song.php" method="POST">
      <div class="modal-body">
        <div>
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Song">Song:</label>
            <input type="text" placeholder="Song Name" name="title" class="form-control">
          </div>
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Artist">Artist:</label>
            <input type="text" placeholder="Artist Name" name="artist" class="form-control">
          </div>
          <div class="form-group has-search mt-3">
            <label class="form-control-placeholder" for="Genre">Genre:</label>
            <input type="text" placeholder="Genre" name="genre" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer modal-footer border-0">
        <button type="submit" class="btn btn-sm btn-outline-success">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script src="js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $(".fa-edit").on("click", function() {

    var songId = $(this).data("id");

    $.ajax({
      url: "backend/get-song.php",
      type: "GET",
      data: {
        songId: songId
      },
      success: function(response) {
        var song = JSON.parse(response);
        $("#songId").val(song.id);
        $("#title").val(song.title);
        $("#artist").val(song.artist);
        $("#genre").val(song.genre);


        $("#updateModal").css("display", "block");
      },
      error: function(xhr, status, error) {
        // Handle errors
        console.log(error);
      }
    });
  });

});

$(document).ready(function() {
  $(".fa-remove").on("click", function() {

    var songId = $(this).data("id");
    $("#deletedSongID").val(songId)
      $("#confirmDeleteBtn").on("click", function() {
        deleteRecord(recordId);
        $.ajax({
        url: "backend/delete-song.php",
        type: "POST",
        data: {
          songId: songId
        },
        success: function(response) {
          alert("song deleted")
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });

    });
  });

});
          
</script>

</body>
</html>

