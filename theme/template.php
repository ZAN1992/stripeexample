<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="./js/color-modes.js" type="javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Stripe example</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/pricing/">

    <!-- Custom styles for this template -->
    <link href="./css/pricing.css">
    <link href="http://englisher.local/stripe-integration/theme/css/base.css" rel="stylesheet">

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('<?=$pk?>');
        var elements = stripe.elements();
    </script>
  </head>
  <body>

<div class="container py-3">
  <header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <img src="https://fanshelden.de/wp-content/uploads/2021/06/Stripe-Logo-2009-uai-258x145.png" width="100" height="50" />
          <span class="fs-4">example</span>
      </a>

      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/user">Users</a>
      </nav>
    </div>

    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
      <h1 class="display-4 fw-normal text-body-emphasis">Products</h1>
    </div>
  </header>

  <main>
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Base</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$5<small class="text-body-secondary fw-light">/day</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>5 users included</li>
              <li>2 GB of storage</li>
              <li>Email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-outline-primary btn-modal" data-product-price="5" data-product-period="day" data-product-sku="base" data-bs-toggle="modal" data-bs-target="#orderModal">Buy</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Standard</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$15<small class="text-body-secondary fw-light">/week</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>20 users included</li>
              <li>10 GB of storage</li>
              <li>Priority email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-primary btn-modal" data-product-price="20" data-product-period="week" data-product-sku="standard" data-bs-toggle="modal" data-bs-target="#orderModal">Buy</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm border-primary">
          <div class="card-header py-3 text-bg-primary border-primary">
            <h4 class="my-0 fw-normal">Enterprise</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$290<small class="text-body-secondary fw-light">/mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>30 users included</li>
              <li>15 GB of storage</li>
              <li>Phone and email support</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-primary btn-modal" data-product-price="290" data-product-period="month" data-product-sku="enterprise" data-bs-toggle="modal" data-bs-target="#orderModal">Buy</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <section>
      <!-- Modal -->
      <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h1 class="modal-title fs-5" id="orderModalLabel">
                          Stripe Example
                      </h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="payment-form" action="/" method="POST">
                          <div class="payment-info" style="padding: 20px;">
                              <fieldset>
                                  <div class="row group">
                                      <div class="group-elements">
                                          <label for="name">Name</label>
                                          <input id="name" name="name" class="field" type="text" placeholder="Jane Doe" required="" autocomplete="name">
                                      </div>

                                  </div>
                                  <div class="row group">
                                      <div class="group-elements">
                                        <label for="email">Email</label>
                                        <input id="email" name="email" class="field" type="email" placeholder="janedoe@gmail.com" required="" autocomplete="email">
                                      </div>
                                  </div>
                              </fieldset>
                              <fieldset>
                                  <div class="row group">
                                      <div class="group-elements">
                                          <label>Card</label>
                                          <div id="card-element" class="field">
                                              <!-- Elements will create input elements here -->
                                          </div>
                                      </div>
                                      <input type="hidden" name="product[name]" id="product_name" />
                                      <input type="hidden" name="product[price]" id="product_price" />
                                      <input type="hidden" name="product[period]" id="product_period" />
                                  </div>
                              </fieldset>

                          </div>

                          <!-- We'll put the error messages in this element -->
                          <div id="card-errors" role="alert"></div>

                          <button id="send" type="submit">Pay</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>

  </section>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="./js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->



  <script>
      // Set up Stripe.js and Elements to use in checkout form
      var elements = stripe.elements();
      var style = {
          base: {
              iconColor: '#666EE8',
              color: '#31325F',
              lineHeight: '40px',
              fontWeight: 300,
              fontFamily: 'Helvetica Neue',
              fontSize: '16px',

              '::placeholder': {
                  color: '#CFD7E0',
              },
          },
      };

      var card = elements.create("card", { style: style, hidePostalCode: true });
      card.mount("#card-element");
      card.on('change', ({error}) => {
          let displayError = document.getElementById('card-errors');
          if (error) {
              displayError.textContent = error.message;
          } else {
              displayError.textContent = '';
          }
          //console.log(value);
      });

      document.querySelectorAll('.btn-modal').forEach((item, i) => {
          item.addEventListener('click', (e) => {
              let price = e.target.getAttribute('data-product-price');
              let sku = e.target.getAttribute('data-product-sku');
              let period = e.target.getAttribute('data-product-period');

              document.getElementById('product_name').setAttribute('value', sku);
              document.getElementById('product_price').setAttribute('value', price);
              document.getElementById('product_period').setAttribute('value', period);
          })
      });

      document.querySelector('#send').addEventListener('click', (e)=> {
          e.preventDefault();
          stripe.createToken(card).then((result) => {
              let displayError = document.getElementById('card-errors');
              if (result.error) {
                  displayError.textContent = result.error.message;
              } else {
                  displayError.textContent = '';
                  let form = document.getElementById('payment-form');
                  let stripeInput = document.createElement('input');
                  stripeInput.setAttribute('type', 'hidden');
                  stripeInput.setAttribute('name', 'stripeToken');
                  stripeInput.setAttribute('value', result.token.id);
                  form.appendChild(stripeInput);

                  form.submit();
              }
          });
         /* let var1 = elements.getElement('card');
          console.log(var1);
          console.log(card);

          let val = document.querySelector('iframe');
            console.log(val);
          //let val = document.querySelector('input[name="cardnumber"]').getAttribute('value');
          console.log(val);
          document.querySelector('#card').setAttribute('value', val);
      */});
  </script>
</body>
</html>
