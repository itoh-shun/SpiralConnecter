# SpiralConnecter

Creator: Shun Itoh by Spiral Inc.

このプログラムはスパイラル社のSpiral v1で利用できます。

SpiralのDBを簡単に扱うことができます。
必須ライブラリ
※ https://github.com/itoh-shun/Collection/


## SpiralDBの使い方（トークンシークレット利用する場合）
トークンとシークレットを利用して接続する場合は、事前に設定が必要です。
~~~
SpiralDB::setToken('YOUR_TOKEN', 'YOUR_SECRET');
~~~

このようにトークンを設定しましょう。

## DBタイトルを使用してデータマネージャを取得
Spiralのデータベースのタイトルを設定しましょう。
### fields
デフォルトのフィールドをセットします。
~~~
SpiralDB::title('db_title')->fields(['field1', 'field2']);
~~~

### where
検索条件をセットします。
~~~
SpiralDB::title('db_title')->fields(['field1', 'field2'])->where('field1' , $value );

SpiralDB::title('db_title')->fields(['field1', 'field2'])->where('field1' , $value , '!=');
~~~

### orWhere
OR検索条件をセットします。
~~~
SpiralDB::title('db_title')->fields(['field1', 'field2'])->orWhere('field1' , $value );

SpiralDB::title('db_title')->fields(['field1', 'field2'])->orWhere('field1' , $value , '!=');
~~~

### whereIn
IN検索条件をセットします。
~~~
SpiralDB::title('db_title')->fields(['field1', 'field2'])->whereIn('field1' ,  ['value1', 'value2']);
~~~

### whereNotIn
NOT IN検索条件をセットします。
~~~
SpiralDB::title('db_title')->fields(['field1', 'field2'])->whereNotIn('field1' ,  ['value1', 'value2']);
~~~

### schema
データベースのスキーマを取得します。
~~~
SpiralDB::title('db_title')->schema();
~~~

### registedRecordCount
登録されているレコードの数を取得します。
~~~
SpiralDB::title('db_title')->registedRecordCount();
~~~

### reInstance
新しいインスタンスを取得します。
~~~
SpiralDB::title('db_title')->reInstance();
~~~

### nextId
次のIDを取得します。
~~~
SpiralDB::title('db_title')->nextId();
~~~


### get
データベースからレコードを取得します。このメソッドは、前にセットされた条件やフィールド設定に基づいてレコードを取得します。

返却値はCollectionインスタンスです。

~~~
$data = SpiralDB::title('db_title')->fields(['field1', 'field2'])->get();
~~~

### create
データベースに1レコード登録します。
返却値には登録したレコードIdを付与したレスポンスを受け取れます。
~~~
$data = ['field1' => 'value1', 'field2' => 'value2'];
$create = SpiralDB::title('db_title')->create($data);
$create->id;// 登録したレコードID
~~~

### insert
データベースに複数レコード登録します。
返却値はブーリアンです。
~~~
$data = [
    ['field1' => 'value1', 'field2' => 'value2']
    ['field1' => 'value1', 'field2' => 'value2']
];

SpiralDB::title('db_title')->insert($data);

~~~

### update
検索値に一致したレコードに対して更新します
返却値は更新した件数です
~~~
$data = ['field1' => 'value1', 'field2' => 'value2'];

$count = SpiralDB::title('db_title')->update($data);
~~~


### upsert
keyに一致した値を更新します。一致しない場合は登録を行います。
返却値は'inserted' もしくは 'updated' です。
~~~
$data = ['field1' => 'value1', 'field2' => 'value2'];

$status = SpiralDB::title('db_title')->upsert('field1',$data);
~~~


### delete
検索条件に一致したレコードを削除します。
返却値は削除したレコード数です
~~~

$count = SpiralDB::title('db_title')->delete();
~~~


### destroy
レコードIDでレコードを削除します。
~~~

SpiralDB::title('db_title')->destroy(1);
~~~

### updateBulk
複数のレコードをまとめて更新します
~~~

$data = [
    ['userId'=> 1 ,'field1' => 'value1', 'field2' => 'value2']
    ['userId'=> 2 ,'field1' => 'value1', 'field2' => 'value2']
];
SpiralDB::title('db_title')->updateBulk('userId',$data);
~~~

### upsertBulk
複数のレコードをまとめて更新登録します
~~~

$data = [
    ['userId'=> 1 ,'field1' => 'value1', 'field2' => 'value2']
    ['userId'=> 2 ,'field1' => 'value1', 'field2' => 'value2']
];
SpiralDB::title('db_title')->upsertBulk('userId',$data);
~~~


## Model を作ろう
~~~
SpiralDB::title('users')->fields(['id','email','name']);
~~~

こういった指定を毎回していては大変です。
そこで簡単にアクセスできるようにModelを作りましょう。

~~~
use SiLibrary\SpiralConnecter\SpiralModel;
use SiLibrary\SpiralConnecter\SpiralManager;

class User extends SpiralModel {

    // テーブル名と主キーの設定
    protected array $fields= ['id','mailAddress','nameSei','nameMei' , 'password'];
    protected string $db_title = 'User';
    protected string $primaryKey = 'mailAddress';

    // 新しいユーザーの作成例
    public static function createNewUser($mailAddress, $nameSei, $nameMei , $password)
    {
        $user = new self();
        $user->mailAddress= $mailAddress;
        $user->nameSei= $nameSei;
        $user->nameMei= $nameMei;
        $user->password = $password;
        $user->save();

        return $user;
    }
}
~~~

こうすることで、このようにユーザー作成が可能になります。

~~~
$user = User::createNewUser('hoge@sample.com', 'hoge', 'fuga' , 'hogefuga');
~~~

### SpiralModel の機能

#### __get __set

\$fields に指定したキーのみマジックメソッドを使って上書きができます。

#### find 

primaryKey と一致するインスタンスを取得します。
~~~
use SiLibrary\SpiralConnecter\SpiralModel;
use SiLibrary\SpiralConnecter\SpiralManager;

class User extends SpiralModel {

    // テーブル名と主キーの設定
    protected array $fields= ['id','mailAddress','nameSei','nameMei' , 'password'];
    protected string $db_title = 'User';
    protected string $primaryKey = 'mailAddress';

    // レコード取得
    public static function findByEmailAddress($emailAddress)
    {
        return self::find($emailAddress);
    }
}
~~~
このように取得できます。
~~~
$user = User::findByEmailAddress('hoge@sample.com');
~~~

#### all 

条件に一致する情報をすべて配列で取得します。
~~~
use SiLibrary\SpiralConnecter\SpiralModel;
use SiLibrary\SpiralConnecter\SpiralManager;

class User extends SpiralModel {

    // テーブル名と主キーの設定
    protected array $fields= ['id','mailAddress','nameSei','nameMei' , 'password', 'gender'];
    protected string $db_title = 'User';
    protected string $primaryKey = 'mailAddress';

    // 男だけ取得
    public static function getMens()
    {
        $instance = new static();
        $instance->getManager()->where('gender', 'men');
        $users = $instance->all();
        return $users;
    }
}
~~~
このように取得できます。
~~~
$mens = User::getMens();
~~~

#### save 

インスタンスに変更を加え、その内容で登録更新します。
~~~
$user = User::findByEmailAddress('hoge@sample.com');
$user->nameSei = 'ほげ沢';
$user->save();
~~~

## メールを送信
メール送信にはExpress2配信のAPIを利用します。

### サンプリング配信
~~~
SpiralDB::mail('db_title')
    ->mailField('email')
    ->subject('mail title')
    ->mailType('text') // text, html , multipart
    ->bodyText('body')
    ->bodyHtml('body')
    ->formAddress('hoge@text.com')
    ->formName('SPIRAL')
    ->replyTo('hogehoge')
    ->selectName('hogehoge')
    ->ruleId('0000000')
    ->standby('t') // t or f
    ->sampling([
        1,2,3,4,5,6,7,8 ・・・
    ]);
~~~

### 配信予約
~~~
SpiralDB::mail('db_title')
    ->mailField('email')
    ->subject('mail title')
    ->mailType('text') // text, html , multipart
    ->bodyText('body')
    ->bodyHtml('body')
    ->formAddress('hoge@text.com')
    ->formName('SPIRAL')
    ->replyTo('hogehoge')
    ->selectName('hogehoge')
    ->ruleId('0000000')
    ->standby('t') // t or f
    ->reserveDate();
    ->regist();
~~~
