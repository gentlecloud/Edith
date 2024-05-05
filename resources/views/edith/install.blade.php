<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Newly系统安装</title>

    <!-- Newly Install Css -->
    <link href="{{ asset('assets/newly/css/new_install.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/static/lib/ydui/css/ydui.css') }}" rel="stylesheet">
    <link href="//at.alicdn.com/t/font_1798933_1znv0wxuarx.css" rel="stylesheet">
    <script src="{{ asset('assets/static/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/ydui/js/ydui.flexible.js') }}"></script>
</head>
<body class="install-page">

<div class="install-body">
    <div class="install-bg install-start install-loading" id="install-service">
        <div class="install-form">
            <h3>Newly 环境检测 / 许可协议</h3>
            <ul>
                <li>
                    <div class="label">
                        操作系统：
                    </div>
                    <div class="value">
                        {{ PHP_OS }}
                    </div>
                </li>
                <li>
                    <div class="label">
                        Laravel版本：
                    </div>
                    <div class="value">
                        v{{ Illuminate\Foundation\Application::VERSION }}
                    </div>
                </li>
                <li>
                    <div class="label">
                        PHP版本：
                    </div>
                    <div class="value">
                        >= v7.4 当前：v{{ PHP_VERSION }} <div class="{{ $php_mysql == 'none' ? 'newly-error' : 'newly-success' }}"></div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        Mysql：
                    </div>
                    <div class="value">
                        >= v5.7
                        <span id="mysql-version">
                            {{ $php_mysql == 'none' ? '不支持Mysql' : '支持' . $php_mysql }}
                            <div class="{{ $php_mysql == 'none' ? 'newly-error' : 'newly-success' }}"></div>
                        </span>

                    </div>
                </li>
                <li>
                    <div class="label">
                        Symlink：
                    </div>
                    <div class="value">
                        函数{{ in_array('symlink',$php_disabled) ? '已禁用' : '已开启' }} <div class="{{ in_array('symlink',$php_disabled) ? 'newly-error' : 'newly-success' }}"></div>
                    </div>
                </li>
                <li>
                    <div class="label">
                        Passthru：
                    </div>
                    <div class="value">
                        函数{{ in_array('passthru',$php_disabled) ? '已禁用' : '已开启' }} <div class="{{ in_array('passthru',$php_disabled) ? 'newly-error' : 'newly-success' }}"></div>
                    </div>
                </li>
                <li></li>
                <li>
                    <div class="label">
                        官方网站
                    </div>
                    <div class="value">
                        <a href="https://www.newly.cc" target="_blank">Www.Newly.Cc</a>
                    </div>
                </li>
                <li>
                    <div class="label">
                        帮助文档
                    </div>
                    <div class="value">
                        <a href="https://wiki.newly.cc" target="_blank">帮助文档</a> /
                        <a href="https://market.newly.cc" target="_blank">Newly模块市场</a>
                    </div>
                </li>
                <li class="check-line">
                    <div class="label">
                        许可协议
                    </div>
                    <div class="value">
                        <div class="value-check" onclick="checkAccept()">
                            <label><i class="iconfonts icon-dagou" id="accept"></i></label>
                        </div>
                        已阅读并同意<a href="">《Newly系统》</a>及<a href="">《Newly模块》</a>许可协议
                    </div>
                </li>
                <li class="accept-service">
                    <div class="label"></div>
                    <div class="value accept-button">
                        <button type="button" onclick="checkAccept()">同意协议</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div id="setting-form" class="install-bg" style="display: none;">
        <div class="install-form">
            <h3 id="describe">初始化数据库配置</h3>
            <div class="newly-form">
                <div id="database">
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库地址：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_HOST" placeholder="请输入数据库地址" value="{{ $info['db_host'] }}">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库端口：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_PORT" placeholder="请输入数据库端口，默认3306" value="{{ $info['db_port'] }}">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库名：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_DATABASE" placeholder="请输入数据库名" value="{{ $info['db_name'] }}">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库账号：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_USERNAME" placeholder="请输入数据库账号" value="{{ $info['db_username'] }}">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库密码：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_PASSWORD" placeholder="请输入数据库密码" value="{{ $info['db_password'] }}">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            数据库表前缀：
                        </div>
                        <div class="newly-items">
                            <input type="text" name="DB_PREFIX" placeholder="请输入数据库表前缀，可留空" value="{{ $info['db_prefix'] }}">
                        </div>
                    </div>
                </div>
                <div id="account" style="display: none;">
                    <div class="newly-form-item">
                        <div class="newly-label">
                            管理员账号
                        </div>
                        <div class="newly-items">
                            <input type="text" name="user_name" placeholder="请输入初始后台管理员账号">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            密码
                        </div>
                        <div class="newly-items">
                            <input type="password" name="password" placeholder="请输入初始后台管理员密码">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            确认密码
                        </div>
                        <div class="newly-items">
                            <input type="password" name="two_password" placeholder="请输入确认后台管理员密码">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            管理员邮箱
                        </div>
                        <div class="newly-items">
                            <input type="text" name="email" placeholder="请输入管理员邮箱">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            Newly 云账号
                        </div>
                        <div class="newly-items">
                            <input type="text" name="account" placeholder="请输入Newly云账号">
                        </div>
                    </div>
                    <div class="newly-form-item">
                        <div class="newly-label">
                            Newly 云密码
                        </div>
                        <div class="newly-items">
                            <input type="password" name="newly_password" placeholder="请输入Newly云密码">
                        </div>
                    </div>
                </div>
                <div class="newly-form-button">
                    <div class="newly-items accept-button">
                        <button id="install" type="button" disabled>{{ $is_lock ? '您已成功安装Newly系统！如需重新安装，请删除根目录install.lock' : '立即配置'}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="install-loading-bg"></div>
<div class="install-step-loading">
    <div class="install-copyright">
        Copyright © {{ date('Y') }} <a href="https://www.truecharm.cn">初创网络科技</a> Newly著作权登记号： 2021SR1050653
    </div>
</div>

<script src="{{ asset('assets/static/lib/ydui/js/ydui.js') }}"></script>
<script>
    var is_accept = false;
    var is_install = "{{ $is_install }}";
    var step = "database";
    var progressNum = 2;
    var interValId = null;

    $(function () {
        setTimeout(() => {
            $('.install-start').removeClass('install-loading');
            $('.install-start').addClass('install-end');
        }, 350);
    })

    $('#install').on('click',function () {
        if (!is_accept) {
            YDUI.dialog.toast('请阅读并同意许可协议！','error',1500);
            return;
        }
        if (!is_install) {
            YDUI.dialog.toast('环境检测不通过！','error',1500);
            return;
        }
        if (step === 'install') {
            install();
            return;
        }
        var DB_HOST = $('input[name=DB_HOST]').val();
        var DB_PORT = $('input[name=DB_PORT]').val();
        var DB_DATABASE = $('input[name=DB_DATABASE]').val();
        var DB_USERNAME = $('input[name=DB_USERNAME]').val();
        var DB_PASSWORD = $('input[name=DB_PASSWORD]').val();
        var DB_PREFIX = $('input[name=DB_PREFIX]').val();
        if (!DB_HOST) {
            YDUI.dialog.toast('请输入数据库地址','error',1500);
            return;
        }
        if (!DB_PORT) {
            YDUI.dialog.toast('请输入数据库端口','error',1500);
            return;
        }
        if (!DB_DATABASE) {
            YDUI.dialog.toast('请输入数据库名称','error',1500);
            return;
        }
        if (!DB_USERNAME) {
            YDUI.dialog.toast('请输入数据库账号','error',1500);
            return;
        }
        if (!DB_PASSWORD) {
            YDUI.dialog.toast('请输入数据库密码','error',1500);
            return;
        }
        $('#install').attr('disabled', 'disabled');
        $('#install').html('配置中...');
        $('#install').addClass('install-button-loading');
        $.post("",{DB_HOST,DB_PORT,DB_DATABASE,DB_USERNAME,DB_PASSWORD,DB_PREFIX, step},function (res) {
            if (res.status === 'success') {
                step = 'check';
                check();
            } else {
                $('#install').html('重新设置');
                YDUI.dialog.toast(res.msg, 'error', 2000);
            }
        })
    });

    function check() {
        progress('one');
        $.post("",{step},function (res) {
            $('#install').attr('disabled',false);
            $('#install').removeClass('install-button-loading');
            if (res.status === 'success') {
                $('#describe').html('设置管理员账号密码');
                $('#install').html('立即安装');
                $('#database').hide();
                $('#account').show();
                step = 'account';
                var html = '<div class="newly-success"></div>';
                if (!res.data.is_install) {
                    html = '<div class="newly-error"></div>';
                }
                $('#mysql-version').html('当前：v' + res.data.version + html);
                is_install = res.data.is_install;
                step = 'install';
                YDUI.dialog.toast(res.msg, 'success', 1500);
            } else {
                step = 'database';
                $('#install').html('重新安装');
                YDUI.dialog.toast(res.msg, 'error', 1500);
            }
        })
    }

    function install() {
        var user_name = $('input[name=user_name]').val();
        var password = $('input[name=password]').val();
        var two_password = $('input[name=two_password]').val();
        var email = $('input[name=email]').val();
        var account = $('input[name=account]').val();
        var newly_password = $('input[name=newly_password]').val();
        if (!user_name) {
            YDUI.dialog.toast('请输入管理账号','error',1500);
            return;
        }
        if (!password) {
            YDUI.dialog.toast('请输入管理密码','error',1500);
            return;
        }
        if (password != two_password) {
            YDUI.dialog.toast('两次输入密码不一致','error',1500);
            return;
        }

        if (!account || !newly_password) {
            YDUI.dialog.toast('请输入Newly云账号/密码','error',1500);
            return;
        }
        progress();
        $.post("",{user_name,password,email,account,newly_password,step},function (res) {
            if (res.status === 'success') {
                if (!interValId) {
                    clearInterval(interValId);
                    progressNum = 100;
                    progress('finish');
                }
            } else {
                YDUI.dialog.toast(res.msg, 'error', 2000);
            }
        })
    }

    function checkAccept() {
        if (step !== "database") {
            return;
        }
        is_accept = !is_accept;
        if (is_accept !== false) {
            $('#accept').addClass('active');
            // $('.accept-button button').addClass('active');
            $('#install').attr('disabled',false);

            $('#setting-form').show();
            $('#setting-form').addClass('newly-loading');
            $('#setting-form').removeClass('newly-close-loading');
            $('.install-step-loading').show();
            $('.install-loading-bg').show();
            $('#install-service').addClass('install-service');
        } else {
            $('#install-service').removeClass('install-service');
            $('#accept').removeClass('active');
            // $('.accept-button button').removeClass('active');
            $('#install').attr('disabled', 'disabled');

            $('#setting-form').removeClass('newly-loading');
            $('#setting-form').addClass('newly-close-loading');
            $('.install-step-loading').hide();
            $('.install-loading-bg').hide();

            setTimeout(() => {
                $('#setting-form').hide();
            },330);
        }
    }

    function progress(type = 'auto') {
        interValId = setInterval(() => {
            var style = document.createElement('style');
            document.head.appendChild(style);
            sheet = style.sheet;
            if (progressNum * 10 >= 85) {
                sheet.addRule('.install-step-loading::after','width:85%');
                clearInterval(interValId);
                interValId = null;
            } else {
                sheet.addRule('.install-step-loading::after','width:'+ progressNum * 10 +'%');
                progressNum++;
            }

            if (type !== 'auto') {
                clearInterval(interValId);
                interValId = null;
            }
        },1000)
    }
</script>
</body>
</html>
