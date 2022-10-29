<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use Image;

class HomeSliderController extends Controller
{
    public function HomeSlider(){
        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all',compact('homeslide'));
    } // end method

    public function UpdateSlider(Request $request){
        $slide_id = $request->id;
        if ($request->file('home_image')){
            $image = $request->file('home_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            
            Image::make($image)->resize(636,852)->save('upload/home_image/'.$name_gen);
            $save_url = 'upload/home_image/'.$name_gen;

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Home Slide Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);

        } else{
            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
            ]);
            $notification = array(
                'message' => 'Home Slide Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        } // end else

    } // end method
}
