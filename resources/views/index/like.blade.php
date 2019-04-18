@foreach($arr as $v)
    <li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
        <a href="/content?goods_id={{$v->goods_id}}" class="g-pic">
            <img class="lazy" src="{{URL::asset('goodsimg/'.$v->goods_img)}}" name="goodsImg"  width="136" height="136">
        </a>
        <p class="g-name">{{$v->goods_name}}</p>
        <ins class="gray9">价值：￥{{$v->goods_selfprice}}</ins>

        <div class="Progress-bar">
            <p class="u-progress">
                    <span class="pgbar" style="width: 96.43076923076923%;">
                    <span class="pging"></span>
                    </span>
            </p>
        </div>
        <div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
            <a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
            <div class="gRate" codeid="12751965" canbuy="58">
                <a href="javascript:;"></a>
            </div>
        </div>
    </li>
@endforeach
