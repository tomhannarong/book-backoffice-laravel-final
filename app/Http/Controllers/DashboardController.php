<?php

namespace App\Http\Controllers;

use App\OrderMas;
use App\Tranfer;
use App\OrderHistory;
use App\WebConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $webconfig = WebConfig::first();

        $order_new_count = DB::table('order_mas')
                     ->select(DB::raw('count(id) as order_new_count'))
                     ->where('order_status', 'รอชำระเงิน')
                     ->where('show_status' , 'y')
                     ->first();
        $tranfer_new_count = DB::table('tranfer')
                     ->select(DB::raw('count(id) as tranfer_new_count'))
                    //  ->where('show_status' , 'y')
                     ->where('tranfer_status', 'รอตรวจสอบ')
                     ->first();
        $order_payed_count = DB::table('order_mas')
                     ->select(DB::raw('count(id) as order_payed_count'))
                     ->where('order_status', 'ชำระเงินแล้ว')
                     ->where('tracking_number' , null)->where('book_available' , 'y')
                     ->where('show_status' , 'y')
                     ->first();
        $order_sended_count = DB::table('order_mas')
                     ->select(DB::raw('count(id) as order_sended_count'))
                     ->where('order_status', 'ชำระเงินแล้ว')
                     ->whereNotNull('tracking_number')->where('book_available' , 'y')
                    //  ->where('show_status' , 'n')
                     ->first();
                     
        $order_cancel_period = OrderMas::select(DB::raw('count(id) as order_cancel_period'))
                     ->where('order_status', 'รอชำระเงิน')
                     ->where('show_status' , 'y')
                     ->where('created_at' ,'<', Carbon::now()->subDays($webconfig->cancel_time)->toDateTimeString())
                     ->first();

        if(!$order_new_count){
            $order_new_count->order_new_count = 0;
        }
        if(!$tranfer_new_count){
            $tranfer_new_count->tranfer_new_count = 0;
        }
        if(!$order_payed_count){
            $order_payed_count->order_payed_count = 0;
        }
        if(!$order_sended_count){
            $order_sended_count->order_sended_count = 0;
        }
        if(!$order_cancel_period){
            $order_cancel_period->order_cancel_period = 0;
        }

        $order_ebook_approve_count = OrderMas::whereNotNull('approve_status')
                    ->where('order_status','ชำระเงินแล้ว')
                    ->where('approve_status' , 'y')
                    ->select(DB::raw('count(id) as order_ebook_approve_count'))
                    ->first();

        $order_ebook_reject_count = OrderMas::whereNotNull('approve_status')
                    ->where('order_status','ชำระเงินแล้ว')
                    ->where('approve_status' , 'n')
                    ->select(DB::raw('count(id) as order_ebook_reject_count'))
                    ->first();

        if(!$order_ebook_approve_count){
            $order_ebook_approve_count->order_ebook_approve_count = 0;
        }
        if(!$order_ebook_reject_count){
            $order_ebook_reject_count->order_ebook_reject_count = 0;
        }

        // $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Weekly
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $dateMon = $startOfWeek->toDateString();
        $dateTue = $startOfWeek->addDay()->toDateString();
        $dateWed = $startOfWeek->addDay()->toDateString();
        $dateThu = $startOfWeek->addDay()->toDateString();
        $dateFri = $startOfWeek->addDay()->toDateString();
        $dateSat = $startOfWeek->addDay()->toDateString();
        $dateSun = $endOfWeek->toDateString();

        $orderDateMonCount = OrderMas::whereDate('created_at', $dateMon)->count();
        $orderDateTueCount = OrderMas::whereDate('created_at', $dateTue)->count();
        $orderDateWedCount = OrderMas::whereDate('created_at', $dateWed)->count();
        $orderDateThuCount = OrderMas::whereDate('created_at', $dateThu)->count();
        $orderDateFriCount = OrderMas::whereDate('created_at', $dateFri)->count();
        $orderDateSatCount = OrderMas::whereDate('created_at', $dateSat)->count();
        $orderDateSunCount = OrderMas::whereDate('created_at', $dateSun)->count();

        $orderDateOfWeek = [$orderDateMonCount , $orderDateTueCount , $orderDateWedCount ,$orderDateThuCount ,$orderDateFriCount ,$orderDateSatCount , $orderDateSunCount];        
       
        // text focus in chart
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $dateMonDay = $startOfWeek->day;
        $dateTueDay = $startOfWeek->addDay()->day;
        $dateWedDay = $startOfWeek->addDay()->day;
        $dateThuDay = $startOfWeek->addDay()->day;
        $dateFriDay = $startOfWeek->addDay()->day;
        $dateSatDay = $startOfWeek->addDay()->day;
        $dateSunDay = $endOfWeek->day;

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $dateMonMonth = $startOfWeek->format('M');
        $dateTueMonth = $startOfWeek->addDay()->format('M');
        $dateWedMonth = $startOfWeek->addDay()->format('M');
        $dateThuMonth = $startOfWeek->addDay()->format('M');
        $dateFriMonth = $startOfWeek->addDay()->format('M');
        $dateSatMonth = $startOfWeek->addDay()->format('M');
        $dateSunMonth = $endOfWeek->format('M');

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $dateMonYear = $startOfWeek->year;
        $dateTueYear = $startOfWeek->addDay()->year;
        $dateWedYear = $startOfWeek->addDay()->year;
        $dateThuYear = $startOfWeek->addDay()->year;
        $dateFriYear = $startOfWeek->addDay()->year;
        $dateSatYear = $startOfWeek->addDay()->year;
        $dateSunYear = $endOfWeek->year;
       

        $dateMonText = $dateMonMonth . " " .$dateMonDay . " " .$dateMonYear ;
        $dateTueText = $dateTueMonth . " " .$dateTueDay . " " .$dateTueYear ;
        $dateWedText = $dateWedMonth . " " .$dateWedDay . " " .$dateWedYear ;
        $dateThuText = $dateThuMonth . " " .$dateThuDay . " " .$dateThuYear ;
        $dateFriText = $dateFriMonth . " " .$dateFriDay . " " .$dateFriYear ;
        $dateSatText = $dateSatMonth . " " .$dateSatDay . " " .$dateSatYear ;
        $dateSunText = $dateSunMonth . " " .$dateSunDay . " " .$dateSunYear ;

        $dateOfFocus = [$dateMonText , $dateTueText , $dateWedText ,$dateThuText ,$dateFriText ,$dateSatText ,$dateSunText] ;
       
        $orderNew = OrderMas::orderBy('id' , "DESC")->limit(3)->get();
        // DD($orderNew);

        // Monthly
        $startOfMonth = Carbon::now()->startOfYear()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfYear()->endOfMonth();
        
        $monthJanFirst = $startOfMonth->toDateString();
        $monthJanLast = $startOfMonth->endOfMonth()->toDateString();
        $monthFebFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthFebLast = $startOfMonth->endOfMonth()->toDateString();
        $monthMarFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthMarLast = $startOfMonth->endOfMonth()->toDateString();
        $monthAprFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthAprLast = $startOfMonth->endOfMonth()->toDateString();
        $monthMayFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthMayLast = $startOfMonth->endOfMonth()->toDateString();
        $monthJunFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthJunLast = $startOfMonth->endOfMonth()->toDateString();
        $monthJulFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthJulLast = $startOfMonth->endOfMonth()->toDateString();
        $monthAugFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthAugLast = $startOfMonth->endOfMonth()->toDateString();
        $monthSepFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthSepLast = $startOfMonth->endOfMonth()->toDateString();
        $monthOctFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthOctLast = $startOfMonth->endOfMonth()->toDateString();
        $monthNovFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthNovLast = $startOfMonth->endOfMonth()->toDateString();
        $monthDecFirst = $startOfMonth->addDay()->startOfMonth()->toDateString();
        $monthDecLast = $startOfMonth->endOfMonth()->toDateString();
// ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        $JanCount = OrderMas::whereBetween('created_at', [$monthJanFirst, $monthJanLast])->count();
        $FebCount = OrderMas::whereBetween('created_at', [$monthFebFirst, $monthFebLast])->count();
        $MarCount = OrderMas::whereBetween('created_at', [$monthMarFirst, $monthMarLast])->count();
        $AprCount = OrderMas::whereBetween('created_at', [$monthAprFirst, $monthAprLast])->count();
        $MayCount = OrderMas::whereBetween('created_at', [$monthMayFirst, $monthMayLast])->count();
        $JunCount = OrderMas::whereBetween('created_at', [$monthJunFirst, $monthJunLast])->count();
        $JulCount = OrderMas::whereBetween('created_at', [$monthJulFirst, $monthJulLast])->count();
        $AugCount = OrderMas::whereBetween('created_at', [$monthAugFirst, $monthAugLast])->count();
        $SepCount = OrderMas::whereBetween('created_at', [$monthSepFirst, $monthSepLast])->count();
        $OctCount = OrderMas::whereBetween('created_at', [$monthOctFirst, $monthOctLast])->count();
        $NovCount = OrderMas::whereBetween('created_at', [$monthNovFirst, $monthNovLast])->count();
        $DecCount = OrderMas::whereBetween('created_at', [$monthDecFirst, $monthDecLast])->count();


        $orderDateOfMonth = [$JanCount , $FebCount , $MarCount ,$AprCount ,$MayCount ,$JunCount , $JulCount, $AugCount, $SepCount, $OctCount, $NovCount, $DecCount];        
       
        // Yearly
        $startOfMonth = Carbon::now()->startOfYear();

        $monthJan = $startOfMonth->format('M');
        $monthFeb = $startOfMonth->addMonth()->format('M');
        $monthMar = $startOfMonth->addMonth()->format('M');
        $monthApr = $startOfMonth->addMonth()->format('M');
        $monthMay = $startOfMonth->addMonth()->format('M');
        $monthJun = $startOfMonth->addMonth()->format('M');
        $monthJul = $startOfMonth->addMonth()->format('M');
        $monthAug = $startOfMonth->addMonth()->format('M');
        $monthSep = $startOfMonth->addMonth()->format('M');
        $monthOct = $startOfMonth->addMonth()->format('M');
        $monthNov = $startOfMonth->addMonth()->format('M');
        $monthDec = $startOfMonth->addMonth()->format('M');

        $dateMonthYear = $startOfMonth->year;
    
      
        $monthJanText = $monthJan . " " .$dateMonthYear ;
        $monthFebText = $monthFeb . " " .$dateMonthYear ;
        $monthMarText = $monthMar . " " .$dateMonthYear ;
        $monthAprText = $monthApr . " " .$dateMonthYear ;
        $monthMayText = $monthMay . " " .$dateMonthYear ;
        $monthJunText = $monthJun . " " .$dateMonthYear ;
        $monthJulText = $monthJul . " " .$dateMonthYear ;
        $monthAugText = $monthAug . " " .$dateMonthYear ;
        $monthSepText = $monthSep . " " .$dateMonthYear ;
        $monthOctText = $monthOct . " " .$dateMonthYear ;
        $monthNovText = $monthNov . " " .$dateMonthYear ;
        $monthDecText = $monthDec . " " .$dateMonthYear ;

        $dateOfFocusOfMonth = [$monthJanText , $monthFebText ,$monthMarText ,$monthAprText ,$monthMayText ,$monthJunText
         ,$monthJulText ,$monthAugText ,$monthSepText ,$monthOctText ,$monthNovText ,$monthDecText ] ;
        
        $currentYear = Carbon::now()->year ; 
        $yearMinus1 = $currentYear - 1 ;
        $yearMinus2 = $currentYear - 2 ;
        $yearMinus3 = $currentYear - 3 ;
        $yearMinus4 = $currentYear - 4 ;

        $currentYearCount = OrderMas::whereYear('created_at', $currentYear)->count();
        $yearMinus1Count = OrderMas::whereYear('created_at', $yearMinus1)->count();
        $yearMinus2Count = OrderMas::whereYear('created_at', $yearMinus2)->count();
        $yearMinus3Count = OrderMas::whereYear('created_at', $yearMinus3)->count();
        $yearMinus4Count = OrderMas::whereYear('created_at', $yearMinus4)->count();

        $orderDateOfYear = [$yearMinus4Count , $yearMinus3Count , $yearMinus2Count , $yearMinus1Count , $currentYearCount ];  

        $bottomYear = [ $yearMinus4 , $yearMinus3 ,$yearMinus2 ,$yearMinus1 ,$currentYear];        
        
        return view('dashboard' , [
            'bottomYear' => $bottomYear ,
            'orderDateOfYear' => $orderDateOfYear ,
            'dateOfFocusOfMonth' => $dateOfFocusOfMonth ,
            'orderDateOfMonth' => $orderDateOfMonth ,
            'orderNew' => $orderNew ,
            'dateOfFocus' => $dateOfFocus ,
            'orderDateOfWeek' => $orderDateOfWeek ,
            'order_new_count' => $order_new_count ,
            'tranfer_new_count' => $tranfer_new_count ,
            'order_payed_count' => $order_payed_count ,
            'order_sended_count' => $order_sended_count ,
            'order_cancel_period' => $order_cancel_period ,
            'order_ebook_approve_count' => $order_ebook_approve_count ,
            'order_ebook_reject_count' => $order_ebook_reject_count ,
        ]);
    }
}
