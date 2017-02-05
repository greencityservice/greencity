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
    .eventdivider{
      width: 320px;
      margin: 0 auto;
    }
    body{
      padding: 5px
    }
  </style>

</head>
<body id="stream" >

<div class="ui secondary pointing menu">
  <a class="active item">
    <?php echo translate('Home') ?>
  </a>
  
  <div class="right menu">
    <a class="item" href="month.php">
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
  <div class="ui raised centered card">
  
  <div class="content">
    <div class="header eventtitle">Event Title</div>
    <div class="meta eventdate">0 days ago</div>
    <div class="meta eventlocation">Location</div>
    <div class="description eventdescription">
      <p>
      description
      </p>
    </div>
  </div>

  <div class="extra content">
    
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
            
            card.attr('id',id)
            card.find('.eventtitle').text(event._name)
            card.find('.eventdate').text(event._date)
            card.find('.eventlocation').text(event._location)
            card.find('.eventdescription').text(event._description)
            card.find('.eventtitle').text(event._name)
            card.appendTo('#mainframe')
            card.show();
          })
      },'json')
    })
</script>
</body>
</html>









