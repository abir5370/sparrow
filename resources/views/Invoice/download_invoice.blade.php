<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>A simple, clean, and responsive HTML invoice template</title>

   {{-- <link rel="stylesheet" type="text/css" href=""> --}}
   <style>
        *{
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
}
.body{
     padding-bottom: 20px;
  
}
.invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
      
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
      
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
input[type] {
  border: none;
  border-bottom: 1px solid grey;
  
}
input[type=date]{
  border: none;
  
  width: 140px;
}
    
input[type=number1]{
  border: none;
  border-bottom: 1px solid grey;
   width: 137px;
}
input[type=numberquan]{
  border: none;
   width: 60px;
  font-size: 16px;
  text-align: left;
  
}
input[type=numberitem]{
  border: none;
   width: 100px;
  font-size: 16px;
  text-align: left;
  
}

input[type=numberquan2]{
  border: none;
   width: 60px;
  font-size: 16px;
  position: relative;
  left: 73px;
  font-weight: bold;
}
#drpLoginType{
  border: none;
}
  

    
   .title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
      
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
      text-align: left;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
      text-align: left;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
      text-align: left;
    }
p1{
   font-size: 25px;
        line-height: 45px;
  padding-top: 20px;
 
}
#qwert{
  text-align: left;
  position: relative;
  left: 240px;
}
#num1{
   border: none;
   width: 56px;
   font-size: 16px;
   text-align: left;
}
input[type=text],input[type=email]{
  border: none; 
  
}
.p2{
  text-align: left;
}

#num2{
   border: none;
   width: 66px;
  font-size: 16px;
  text-align: left;
    position: relative;
  left: 89px;
 
}

p2,p3{
  position: relative;
  left: 94px;
  
}



button {
  padding: 10px 24px;
  background-color: #e7e7e7; color: black;
  width: 250px;
right: 250px;
  position: relative;
}
button:hover {
  background-color: white;
}
td1{
  
}
   </style>
</head>

<body>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="https://i.postimg.cc/gc5sHNSr/360.jpg" style="width:100%;  border-radius: 20px; max-width:100px;">
                        </td>
                        <div id="qwert">
                            <div>Invoice ID: {{ $order_info->order_id }}</div>
                            <div>Date: {{ $billing_info->first()->created_at->format('d-m-y') }}</div>
                        </div>
                    </tr> 
                </table>
            </td>
      </tr>

      <tr class="information">
        <td colspan="2">
          <table>
            <tr>
              <td style="">    
                    <div>Sparrow Online Shop</div>
                    <address>Dhanmondi,Rode:15</br>Dhaka 1200,Bangladesh</address>
                    <hr>
                    {{-- <input type="text" placeholder="Sunnyville, CA 12345"> --}}
              </td>
              <div id="qwert1" style="margin-left: 110px;">
                    <div>Bill To:</div>
                    <div>NAME: {{ $billing_info->first()->name }}</div>
                    <div>EMAIL: {{ $billing_info->first()->email }}</div>
                    <div>ADDRESS: {{ $billing_info->first()->address }}</div>
              </div>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="heading">
        <td>Item</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Total</td>
      </tr>
      @php
          $sub = 0;
      @endphp
      @foreach ($order_product as $product_info)
        <tr class="item">
            <td>{{ $product_info->rel_to_product->product_name }}</td>
            <td id="num1">{{ $product_info->price }}</td>
            <td>{{ $product_info->quantity }}</td>
            <td>{{ $product_info->price*$product_info->quantity }}</td>
        </tr>  
        @php
            $sub += $product_info->price*$product_info->quantity;
        @endphp
      @endforeach
        <hr>
        <tr class="">
            <td></td>
            <td></td>
            <td colspan="">Sub Total: </td>
            <td> {{ $sub }} </td>
        </tr>
        <tr class="">
            <td></td>
            <td></td>
            <td colspan="">Discount: (-) </td>
            <td> {{ $order_info->discount }} </td>
        </tr>
        <tr class="">
            <td></td>
            <td></td>
            <td colspan="">Charge: (+) </td>
            <td> {{ $order_info->charge }} </td>
        </tr>
      </tr>
      <tr class="">
        <td></td>
        <td></td>
        <td colspan="">Grand Total: </td>
        <td> {{ $order_info->total}} </td>
    </tr>
    <hr></hr>
    </table>
   
  </div>

</body>

</html>