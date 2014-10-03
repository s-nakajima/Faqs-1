
<?php
	if (! isset($viewElement)) {
		$viewElement = 'list_faq';
	}
?>

<?php echo $this->element('Faqs/list_header'); ?>

<hr>

<?php
	$answerIndex = 1;
	$question = 'researchmapに登録したいのですが、初めてなのでどのような資料を参考にすれば登録までスムーズにできますか。';
	$answer = 'researchmapでは、初めて操作いただく方にもわかりやすいように「利用マニュアル」を作成し、掲載しています。<br />
		「【STEP-1】【1】まずresearchmapに行ってみましょう」からご覧いただくと、文章とresearchmapの画面を使って登録完了までを説明しています。<br />
		利用マニュアルはこちらからご覧ください。<br />
		<br />
		操作の詳細については「操作マニュアル」に、比較的お問い合わせの多い内容はFAQに掲載していますので、あわせてご参照ください。<br />
		操作マニュアルはこちらからご覧ください。<br />
		<br />';

	echo $this->element('Faqs/' . $viewElement, array(
							'answerIndex' => $answerIndex,
							'question' => $question,
							'answer' => $answer,
							'published' => false,
							'upDisabled' => true));
?>


<?php
	$answerIndex++;
	$question = '私は大学でresearchmapの担当をしています。researchmapの利用マニュアル（Word版）を自機関で活用したいのですが、入手方法を教えてください。';
	$answer = '利用マニュアルのWord版をご希望の場合は、問い合わせフォームからresearchmap事務局にお問い合わせください。<br />
		問い合わせフォームの「所属」には機関名と部署名を必ずご記入ください。<br />
		<br />';

	echo $this->element('Faqs/' . $viewElement, array(
							'answerIndex' => $answerIndex,
							'question' => $question,
							'answer' => $answer,
							'published' => false));
?>



<?php
	$answerIndex++;
	$question = 'ReaDとResearchmapの両方にIDがあります。どちらを削除すればよいか、どうやって削除すればよいかわかりません。';
	$answer = 'ReaDとResearchmapは、2011年11月1日に正式統合しました。両方のサービスにIDを2つ以上持っている方が少なくとも数千人存在していることが予めわかっています。その方たちは、Researchmap（またはReaD）のＩＤでログインすると、次のような画面が表示されます。<br />
			<br />';

	echo $this->element('Faqs/' . $viewElement, array(
							'answerIndex' => $answerIndex,
							'question' => $question,
							'answer' => $answer,
							'published' => true,
							'status' => '<span class="label label-danger">申請中</span>'));
?>



<?php
	$answerIndex++;
	$question = 'researchmapに複数のＩＤを持っています。放置するとどのようなデメリットがありますか？';
	$answer = 'researchmapはe-Radと情報連携を行っています。今後、大学研究者総覧、大学研究者データベースなど他のシステムと連携する場合があります。<br />
		そのとき、特定の研究者番号をもつ複数の研究者が存在すると、システムが混乱します。<br />
		またReaDとResearchmapそれぞれに重複ＩＤを持つ方は、同じ科研費番号などが登録されていると基本項目（パスワード、所属、プロフィール等）の編集ができません。<br />
		<br />
		重複ＩＤをもつ研究者の方には、できるだけはやくＩＤを一本化していただけるようお願いをいたします。<br />
		また、重複ＩＤをもつ限り、e-Radとの関連付けのような研究情報の流通サイクルからこぼれおちてしまうため、不要なはずの手続きや、手入力が求められるなど、不便な状況が続く恐れもあります。<br />
		今後、具体的にどのような不便が生じるかについては、本項目に随時追記していきます。<br />
		<br />';

	echo $this->element('Faqs/' . $viewElement, array(
							'answerIndex' => $answerIndex,
							'question' => $question,
							'answer' => $answer,
							'published' => false,
							'status' => '<span class="label label-info">下書き</span>'));
?>



<?php
	$answerIndex++;
	$question = 'ReaDのIDで登録した業績一覧を、ResearchmapのIDに移したい。';
	$answer = 'ＣＶの各業績欄（論文・MISC・経歴・書籍・委員歴等）には「エクスポート・インポート」の機能が付いています。<br />
		ReaDのIDで登録した業績をダウンロードするには、まずReaDのIDでresearchmapにログインしてください。その状態で、自分の業績リストを見ると、各業績欄（例：論文）の右上方に「エクスポート」というリンクが表示されることでしょう。<br />
		ここをクリックすると、その業績欄（例：論文）に含まれる項目をCSV形式でダウンロードすることができます。<br />';

	echo $this->element('Faqs/' . $viewElement, array(
							'answerIndex' => $answerIndex,
							'question' => $question,
							'answer' => $answer,
							'published' => false,
							'status' => '<span class="label label-info">下書き</span>'));
?>

<?php echo $this->element('Faqs/list_footer'); ?>
