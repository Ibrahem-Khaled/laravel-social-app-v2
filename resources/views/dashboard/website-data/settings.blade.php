@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">إعدادات الموقع</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook_url">رابط فيسبوك</label>
                                <input type="text" name="facebook_url" id="facebook_url" class="form-control"
                                    value="{{ $settings['facebook_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="twitter_url">رابط تويتر</label>
                                <input type="text" name="twitter_url" id="twitter_url" class="form-control"
                                    value="{{ $settings['twitter_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="instagram_url">رابط انستجرام</label>
                                <input type="text" name="instagram_url" id="instagram_url" class="form-control"
                                    value="{{ $settings['instagram_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="linkedin_url">رابط لينكدإن</label>
                                <input type="text" name="linkedin_url" id="linkedin_url" class="form-control"
                                    value="{{ $settings['linkedin_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="youtube_url">رابط يوتيوب</label>
                                <input type="text" name="youtube_url" id="youtube_url" class="form-control"
                                    value="{{ $settings['youtube_url']->value ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="android_app_url">رابط تطبيق أندرويد</label>
                                <input type="text" name="android_app_url" id="android_app_url" class="form-control"
                                    value="{{ $settings['android_app_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="ios_app_url">رابط تطبيق آيفون</label>
                                <input type="text" name="ios_app_url" id="ios_app_url" class="form-control"
                                    value="{{ $settings['ios_app_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="promotional_video_url">رابط الفيديو الترويجي</label>
                                <input type="text" name="promotional_video_url" id="promotional_video_url"
                                    class="form-control" value="{{ $settings['promotional_video_url']->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="visitor_counter">عدد الزوار</label>
                                <input type="number" name="visitor_counter" id="visitor_counter" class="form-control"
                                    value="{{ $settings['visitor_counter']->value ?? '0' }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
