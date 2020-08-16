<h4>Shopping cart</h4>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Game</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><img src="https://cdn2.techadvisor.co.uk/cmsdata/reviews/3664815/assassins_creed_reg__origins_20171027165549.jpg" alt="" width="150"></th>
      <td>Far Cry 3</td>
      <td>20$</td>
    </tr>
    <tr>
      <th scope="row"><img src="https://cdn2.techadvisor.co.uk/cmsdata/reviews/3664815/assassins_creed_reg__origins_20171027165549.jpg" alt="" width="150"></th>
      <td>Far Cry 4</td>
      <td>30$</td>
    </tr>
    <tr>
      <th scope="row"><img src="https://mspoweruser.com/wp-content/uploads/2018/02/Assassins-Creed-3.jpg" alt="" width="150"></th>
      <td>Pes 2021 Season Update</td>
      <td>20$</td>
    </tr>
  </tbody>
</table>
<h4>Billing information</h4>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Name:</th>
      <th scope="col">Email:</th>
      <th scope="col">Phone:</th>
      <th scope="col">Country:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="font-weight-normal"><?=$_POST['fname'].' '.$_POST['lname']?></th>
      <td><?=$_POST['email']?></td>
      <td><?=$_POST['phone']?></td>
      <td><?=$_POST['country']?></td>
    </tr>
  </tbody>
  <thead>
    <tr>
      <th scope="col">City:</th>
      <th scope="col">Zip/Postal:</th>
      <th scope="col">Address:</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="font-weight-normal"><?=$_POST['city']?></th>
      <td><?=$_POST['postalcode']?></td>
      <td><?=$_POST['address']?></td>
      <td></td>
    </tr>
  </tbody>
</table>
<h4 class="border-bottom">Payment information</h4>
<p>Card number: XXXX-XXXX-XXXX-<?=substr($_POST['cardnumber'], -4)?></p>
<h3 class="text-center">Total price: 70$</h3>
<div class="form-row justify-content-center my-4">
  <a class="btn btn-dark col-auto h-100 mx-2 text-center px-3" href="#carouselExampleIndicators" role="button" data-slide="prev">
    Back
  </a>
  <input type="submit" class="btn btn-dark col-auto h-100 mx-2 text-center px-3" value="Buy Now" id="paymentform_total">
</div>
<script>
$("#paymentform_total").click(function() {
	PaymentFormAjax("next=success&"+GetCardInfo()+'&'+GetAddressInfo());
});
</script>