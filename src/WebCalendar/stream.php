<?php
include_once 'includes/init.php';

//check UAC
if ( ! access_can_access_function ( ACCESS_MONTH ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();

  
if ( ( $user != $login ) && $is_nonuser_admin )
  load_user_layers ( $user );
else
if ( empty ( $user ) )
  load_user_layers ();

$appStr =  generate_application_name ();

echo send_doctype ( $appStr );
?>

    <link rel="stylesheet" href="semantic-ui/semantic.min.css">
    <script src="jQuery/jquery-3.1.1.min.js"></script>
    <script src="semantic-ui/semantic.min.js"></script>
    
<style type="text/css">
    .column {

    }
    .eventcard{
      margin:15px;
    }
    .eventdescription{
      padding-top: 5px;
    }
    .eventdivider{
      margin:30px 15px 30px 15px;
    }
    .map{
      /*height: 180px;*/
    }
    .image_category{
      width: 32px;
      height: 32px;
    }
    body{
      padding: 5px
    }
  </style>

</head>
<body id="stream" >

<div class="ui secondary pointing menu">
  <a class="active item">
    <i class="large fitted home icon"></i>
    <?php echo translate('Home') ?>
  </a>
  
  <div class="right menu">
    <a class="item" href="month.php">
      <i class="fitted desktop icon"></i>
      <?php echo translate('Desktop Version') ?>
    </a>
    <a class="ui item" href="login.php?action=logout">
      <?php echo translate('Logout') ?>
    </a>
  </div>
</div>

<!-- <div class="ui segment">
  <p></p>
</div> -->

<div class="ui one column grid">
<div class="column" id='mainframe'>
    <h2 class="ui header"><?php echo translate('Upcoming Events') ?></h2>
</div>
</div>

<div id='cardtemplate' class="eventcard">
  <div class="ui raised centered fluid card">

  <div class="content">
    <img class="ui left floated image image_category" src="">
    <div class="header eventtitle">Event Title</div>
    <!-- <div class="meta eventdate">0 days ago</div> -->
    <div class="meta">Published by: <span class='eventby'></span> on <span class='eventdate'></span></div>
    <!-- <div class="meta eventlocation">Location</div> -->
    <div class="description eventdescription">
      <p>
      description
      </p>
    </div>
  </div>

  <div class="content mapcontent">
    <p>
      <?php echo translate('Location') ?>: <i class="marker icon"></i><span class="eventlocation"></span>
    </p>
    <p class='map'>
    </p>
  </div>

  <div class="extra content">
  </div>
  
  <div class="ui buttons">
    <button class="ui blue button button_details"><?php echo translate('View Details') ?></button>
    <div class="or"></div>
    <button class="ui positive button button_attend"><?php echo translate('I Will Attend') ?></button>
  </div>
  
  </div>
</div>

<div id="dividertemplate" class="eventdivider">
  <h4 class="ui horizontal divider header">
    <span class="eventdate">Divider</span>
  </h4>
</div>

<script type="text/javascript">
    $(function(){
      var map_width = $('#cardtemplate .map').width() - 15
      var map_height = Math.floor(map_width*3/4)
      $('#cardtemplate').hide();
      $('#dividertemplate').hide();
      $.get('stream_handler.php',null,function(data){
        var last_date = '';
          data.forEach(function(event){
            var id = 'event'+event._id

            if(event._date != last_date)
            {
                last_date = event._date;
                var date_divider = $('#dividertemplate').clone();
                date_divider.attr('id','divider'+last_date)
                date_divider.find('.eventdate').text(last_date);
                date_divider.appendTo('#mainframe');
                date_divider.show();
            }
            var card = $('#cardtemplate').clone();
            var images=['images2/eraser.png','images2/maid.png','images2/vacuum-cleaner.png','images2/vacuum-cleaner-2.png','images2/washing-machine.png','images2/vacuum-cleaner-3.png']

            card.attr('id',id)
            card.find('.image_category').attr('src',images[Math.floor(Math.random()*images.length)])
            card.find('.eventtitle').text(event._name)
            card.find('.eventdate').text(event._date)
            card.find('.eventby').text(event._owner)
            card.find('.eventdescription').html(event._description.replace(/\r\n/g,'<br>'))
            card.find('.eventtitle').text(event._name)
            if (event._location != null && event._location != '') 
            {
              card.find('.eventlocation').text(event._location)
              card.find('.map').html('<img src="https://maps.googleapis.com/maps/api/staticmap?center='+event._location+'&zoom=13&scale=false&size='+map_width+'x'+map_height+'&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C'+event._location+'&key=AIzaSyBRcQ7L8uEzr9RCt6jXMlyK5qvl4q0RCAk" alt="Map">')
            }
            else
            {
              card.find('.mapcontent').hide();
            }
            card.find('.button_details').click(function(){
              location.href='view_entry.php?id='+event._id
            })
            card.find('.button_attend').click(function(){
              var rt = confirm('<?php echo translate('Do you confirm that you will attend this event?') ?>')
              if (rt) {
                //location.href='view_entry.php?id='+event._id
                alert('This function hasn\'t been implemented!')
              }
            })
            card.appendTo('#mainframe')
            card.show();
          })
      },'json')
    })
</script>
</body>
</html>









