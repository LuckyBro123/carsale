<p></p>
<p style="background-color: #e7f6ed; line-height: 1.5;"> ----------------- </p>
@foreach(text2paragraphs($data["message"]) as $paragraph)
	<p>{{$paragraph}}</p>
@endforeach
<p style="background-color: #e7f6ed; line-height: 1.5;"> ----------------- </p>
<p></p>
<p>Email отправителя:</p>
<p>{{$data["sender_email"]}}</p>
