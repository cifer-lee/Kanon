<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome!</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2>买方</h2>
          <div class="row">
            <div class="col-md-4">单号</div>
            <div class="col-md-4">数量</div>
            <div class="col-md-4">价格</div>
          </div>
          <div id="ask">
          </div>
        </div>
        <div class="col-md-6">
          <h2>卖方</h2>
          <div class="row">
            <div class="col-md-4">单号</div>
            <div class="col-md-4">数量</div>
            <div class="col-md-4">价格</div>
          </div>
          <div id="bid">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h2>成交</h2>
          <div class="row">
            <div class="col-md-2">买方单号</div>
            <div class="col-md-2">卖方单号</div>
            <div class="col-md-2">成交价格</div>
            <div class="col-md-2">成交数量</div>
            <div class="col-md-2">成交日期</div>
          </div>

          <div id="match">
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
    snap_timestamp = 0;
    $(function() {

        (function worker() {

          $.ajax({
            url: "/order/" + snap_timestamp,
                method: "GET",
                dataType: "json"
          }).done(function(data, textStatus, jqXHR) {
            asks = jqXHR.responseJSON.asks;
            $("#ask").html('');
            for (i in asks) {
                var d = '';
                d += '<div class="row">';
                d += '<div class="col-md-4">' + asks[i].id + '</div>';
                d += '<div class="col-md-4">' + asks[i].quantity + '</div>';
                d += '<div class="col-md-4">' + asks[i].price + '</div>';
                d += '</div>';
                $("#ask").append(d);
            }

            $("#bid").html('');
            bids = jqXHR.responseJSON.bids;
            for (i in bids) {
                var d = '';
                d += '<div class="row">';
                d += '<div class="col-md-4">' + bids[i].id + '</div>';
                d += '<div class="col-md-4">' + bids[i].quantity + '</div>';
                d += '<div class="col-md-4">' + bids[i].price + '</div>';
                d += '</div>';
                $("#bid").append(d);
            }

            matches = jqXHR.responseJSON.matches;
            for (i in matches) {
                if (i == 0) snap_timestamp = Math.floor(Date.now()/1000);

                var m = new Date(parseInt(matches[i].date) * 1000);
                var dateString =
                m.getFullYear() + "/" +
                ("0" + (m.getMonth()+1)).slice(-2) + "/" +
                ("0" + m.getDate()).slice(-2) + " " +
                ("0" + m.getHours()).slice(-2) + ":" +
                ("0" + m.getMinutes()).slice(-2) + ":" +
                ("0" + m.getSeconds()).slice(-2);

                var d = '';

                d += '<div class="row match-row">';
                d += '<div class="col-md-2">' + matches[i].ask_id + '</div>';
                d += '<div class="col-md-2">' + matches[i].bid_id + '</div>';
                d += '<div class="col-md-2">' + matches[i].price + '</div>';
                d += '<div class="col-md-2">' + matches[i].quantity + '</div>';
                d += '<div class="col-md-2">' + dateString + '</div>';
                d += '<div class="col-md-2"></div>';
                d += '</div>';
                d += '<div class="row bg-info" style="display: none">';
                d += '买方单号: ' + matches[i].ask_id + ', 卖方单号: ' + matches[i].bid_id;
                d += ', 成交价格: ' + matches[i].price + ', 成交量: ' + matches[i].quantity;
                d += ', 成交日期: ' + dateString;
                d += '</div>';

                $("#match").prepend(d);
                $("#match").children().first().click(function(){
                    /*
                    if ($(this).next().css('display') != 'none') {
                        $(this).next().css('display', 'none');
                    } else {
                        $(this).next().css('display', 'block');
                    }
                     */
                    $(this).next().toggle();
                });

                if ($(".match-row").length > 60) {
                    $("#match").children().last().remove();
                    $("#match").children().last().remove();
                }
            }


        }).always(function(){
            setTimeout(worker, 3000);
        });
        })();

    });
    </script>

  </body>
</html>
