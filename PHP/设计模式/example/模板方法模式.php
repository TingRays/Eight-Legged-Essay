<?php
//抽象出来一个下载类
abstract class DownloadSongs {
    protected $singer;
    protected $operator;
    public function __construct($singer) {
        $this->singer = $singer;
    }
    //前置钩子
    protected function beforeDownloadHook() {
        echo '充值' . $this->operator . '会员' . PHP_EOL;
    }
    //后置钩子
    protected function afterDownloadHook() {
        echo $this->operator . '还算好用，就是要充会员' . PHP_EOL;
    }
    //组合调用
    public function download() {
        $this->beforeDownloadHook();
        $this->downloadMusic();
        $this->afterDownloadHook();
    }
    //具体实现让子类进行
    abstract protected function downloadMusic();
}
//酷狗类，实现父类的两个方法
class KuGouMusic extends DownloadSongs {
    protected $operator = '酷狗';
    protected function downloadMusic() {
        echo '从酷狗音乐上下载' . $this->singer . '的歌曲' . PHP_EOL;
    }
}
//QQ类，实现父类的两个方法
class QQMusic extends DownloadSongs {
    protected $operator = 'QQ';
    protected function downloadMusic() {
        echo '从QQ音乐上下载' . $this->singer . '的歌曲' . PHP_EOL;
    }
}
//调用端=======================================================================
(new KuGouMusic('凤凰传奇'))->download();
(new QQMusic('英文'))->download();