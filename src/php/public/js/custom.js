$(".slider").slick({
    autoplay: true, //自動的に動き出すか。初期値はfalse。
    infinite: true, //スライドをループさせるかどうか。初期値はtrue。
    slidesToShow: 2, //スライドを画面に3枚見せる
    slidesToScroll: 2, //1回のスクロールで3枚の写真を移動して見せる
    prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
    nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
    dots: true, //下部ドットナビゲーションの表示
    responsive: [
        {
            breakpoint: 769, //モニターの横幅が769px以下の見せ方
            settings: {
                slidesToShow: 2, //スライドを画面に2枚見せる
                slidesToScroll: 2, //1回のスクロールで2枚の写真を移動して見せる
            },
        },
        {
            breakpoint: 426, //モニターの横幅が426px以下の見せ方
            settings: {
                slidesToShow: 1, //スライドを画面に1枚見せる
                slidesToScroll: 1, //1回のスクロールで1枚の写真を移動して見せる
            },
        },
    ],
});

// スタンプのスライダー設定
$(".slider-stamp").slick({
    autoplay: true, //自動的に動き出すか。初期値はfalse。
    infinite: true, //スライドをループさせるかどうか。初期値はtrue。
    slidesToShow: 3, //スライドを画面に3枚見せる
    slidesToScroll: 1, //1回のスクロールで3枚の写真を移動して見せる
    prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
    nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
    dots: true, //下部ドットナビゲーションの表示
    responsive: [
        {
            breakpoint: 769, //モニターの横幅が769px以下の見せ方
            settings: {
                slidesToShow: 2, //スライドを画面に2枚見せる
                slidesToScroll: 2, //1回のスクロールで2枚の写真を移動して見せる
            },
        },
        {
            breakpoint: 426, //モニターの横幅が426px以下の見せ方
            settings: {
                slidesToShow: 1, //スライドを画面に1枚見せる
                slidesToScroll: 1, //1回のスクロールで1枚の写真を移動して見せる
            },
        },
    ],
});

// モーダル
// $("#my-modal").on("show.bs.modal", function (e) {
//     console.log("show"); //showメソッドが実行されたら実行される。
// });

// $("#my-modal").on("shown.bs.modal", function (e) {
//     console.log("shown"); //見えるようになったら実行される
// });

// $("#my-modal").on("hide.bs.modal", function (e) {
//     console.log("hide"); //hideメソッドが実行されたら実行される
// });

// $("#my-modal").on("hidden.bs.modal", function (e) {
//     console.log("hidden"); //見えなくなったら実行される
// });
