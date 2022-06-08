<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{

    public function index(Business $business)
    {
        $contacts = Contact::where('user_id' , Auth::user()->id)->get();
        return view('app.businesses.bills.contacts.index', compact('contacts','business'));
    }

    public function create(Business $business)
    {
        Log::info(Contact::all()->count() . ' created a new contact');
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'You must create a business first');
        }
        return view('app.businesses.bills.contacts.create', compact('business'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            /*'email' => 'email|max:255',
            'phone_number' => 'max:255',
            'abn' => 'max:255',
            'address' => 'max:255',
            'notes' => 'max:255', */
        ]);

        if ($validator->fails()) {
            if (request()->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 400);
            } else {
                return redirect()->back()->withInput()
                    ->withErrors($validator);
            }
        }


        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->abn = $request->abn;
        $contact->address = $request->address;
        $contact->notes = $request->notes;
        $contact->user_id =  Auth::user()->id;
        $contact->save();

        return redirect('/contacts/business/'.$request->business_id)->with('messageSuc', 'Contact created successfully');
    }
    
    public function edit($id){
        $businesses = Auth::user()->businesses;
        if (count($businesses) < 1) {
            return redirect('/')->with('messageDgr', 'You must create a business first');
        }
        
        $contact = Contact::findOrFail($id);
        return view('app.businesses.bills.contacts.edit', compact('contact'));
         
    }
    public function update(Request $request){
        $contact = Contact::findOrFail($request->id);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone;
        $contact->abn = $request->abn;
        $contact->address = $request->address;
        $contact->notes = $request->notes; 
        $contact->save();


        return redirect('/contacts/business/1')->with('messageScc', 'Contact edited successfully');

    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('messageScc', 'Contact deleted successfully');
    }
}
