<?php
 
namespace App\Swep\Services;

use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Events\Dispatcher;
use App\Models\DisbursementVouchers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\Repository as Cache;

class DisbursementVoucherService{



	protected $disbursement_voucher;
    protected $event;
    protected $cache;
    protected $auth;
    protected $session;




    public function __construct(DisbursementVouchers $disbursement_voucher, Dispatcher $event, Cache $cache){

        $this->disbursement_voucher = $disbursement_voucher;
        $this->event = $event;
        $this->cache = $cache;
        $this->auth = auth();
        $this->session = session();

    }




    public function fetchAll(Request $request){

        $disbursement_vouchers = $this->disbursement_voucher->populate();
        return view('dashboard.disbursement_voucher.index')->with('disbursement_vouchers', $disbursement_vouchers);

    }




    public function store(Request $request){

        $disbursement_voucher = $this->disbursement_voucher->create($request->except(['amount', 'payee', 'address']));
        $this->event->fire('dv.create', [ $disbursement_voucher, $request ]);
        $this->session->flash('SESSION_DV_CREATE_SUCCESS_SLUG', $disbursement_voucher->slug);
        $this->session->flash('SESSION_DV_CREATE_SUCCESS', 'Your Voucher has been successfully Created!');
        return redirect()->back();

    }




    public function update(Request $request, $slug){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });

        $disbursement_voucher->update($request->except(['amount', 'payee', 'address']));
        $this->event->fire('dv.update', [ $disbursement_voucher, $request ]);
        $this->session->flash('SESSION_DV_UPDATE_SUCCESS_SLUG', $disbursement_voucher->slug);
        $this->session->flash('SESSION_DV_UPDATE_SUCCESS', 'Your Voucher has been successfully Updated!');
        return redirect()->back();

    }




    public function show($slug){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });     

        return view('dashboard.disbursement_voucher.show')->with('disbursement_voucher', $disbursement_voucher);

    }




    public function edit($slug){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });     

        return view('dashboard.disbursement_voucher.edit')->with('disbursement_voucher', $disbursement_voucher);

    }




    public function destroy($slug){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });

        $disbursement_voucher->delete();
        $this->session->flash('SESSION_DV_DELETE_SUCCESS', 'Your Voucher has been successfully Deleted!');
        return redirect()->back();

    }




    public function print($slug, $type){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });    

        if($type == 'front'){
            return view('printables.disbursement_voucher')->with('disbursement_voucher', $disbursement_voucher);
        }elseif($type == 'back'){
            return view('printables.disbursement_voucher_back');
        }
        return abort(404);

    }




    public function setNo(Request $request, $slug){

        $disbursement_voucher = $this->cache->remember('disbursement_voucher:bySlug:' . $slug, 240, function() use ($slug){
            return $this->disbursement_voucher->findSlug($slug);
        });    

        $validator = $this->setNoValidate($request);

        $disbursement_voucher->update(['dv_no' => $request->dv_no]);

        $this->session->flash('SESSION_DV_SET_NO_SUCCESS', 'DV No. successfully set!');
        return redirect()->back();

    }




    //Utility Methods
    public function setNoValidate(Request $request){

        $validator = Validator::make($request->all(),[
            'dv_no' => 'nullable|max:50|string',
        ]);

        return $validator->validate();

    }



}