<!DOCTYPE html>
<html>
<head>
      <title>Mange Kimambi App</title>
<style>
.button {
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button1 {background-color: #4CAF50;} /* Green */
.button2 {background-color: #008CBA;} /* Blue */
</style>
</head>
<body>

<h1>{{ $details['title'] }}</h1>
<h3>{{ $details['body'] }}</h3>

<a href="{{ $details['url'] }}"> <button class="button button1">Badili Password</button> </a>
{{-- <button class="button button2">Blue</button> --}}
<p>Asante Kwa kutumia App yetu</p>


<br>

<em style="color:red;">Non repaly email  (Barua pepe isiyo hitaji kujibiwa)</em>
</body>
</html>
