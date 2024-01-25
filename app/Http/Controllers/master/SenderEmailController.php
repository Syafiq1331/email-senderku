<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Mail\KirimEmail;
use App\Models\Antrian;
use App\Models\EmailHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SenderEmailController extends Controller
{
    public function showForm()
    {
        // Mendapatkan daftar email dari model Antrian
        $getEmails = Antrian::where('status', 'diproses')->pluck('email')->unique();


        // Mengirimkan data email ke tampilan Master.SendEmail
        return view('Master.SendEmail', compact('getEmails'));
    }

    // public function sendEmail(Request $request)
    // {
    //     try {
    //         // return response()->json(['success' => $request->all()]);

    //         // Validasi input
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|array',
    //             'email.*' => 'required|email', // Use the * wildcard to validate each item in the array
    //             'subject' => 'required|string',
    //             'message' => 'required|string',
    //         ]);

    //         return response()->json($request->all());

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'message' => 'Invalid input', 'errors' => $validator->errors()]);
    //         }

    //         $data_email = [
    //             'subject' => $request->input('subject'),
    //             'sender_name' => 'bussinesyafiq@gmail.com',
    //             'isi' => $request->input('message')
    //         ];

    //         // Kirim email
    //         foreach ($request->input('email') as $email) {
    //             Mail::to($email)->send(new KirimEmail($data_email));
    //         }

    //         // Simpan data ke dalam tabel email_history
    //         foreach ($request->input('email') as $email) {
    //             EmailHistory::create([
    //                 'email' => $email,
    //                 'subject' => $request->input('subject'),
    //                 'message' => $request->input('message'),
    //             ]);
    //         }

    //         // Berhasil
    //         return response()->json(['success' => true, 'message' => 'Email berhasil terkirim']);
    //     } catch (\Exception $e) {
    //         // Error
    //         return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengirim email: ' . $e->getMessage()]);
    //     }
    // }

    public function sendEmail(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'emails' => 'required|string',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Invalid input', 'errors' => $validator->errors()]);
            }

            // Convert comma-separated string of emails to an array
            $emails = explode(',', $request->input('emails'));

            // Validate each email in the array
            $emailValidator = Validator::make(['emails' => $emails], [
                'emails.*' => 'required|email',
            ]);

            if ($emailValidator->fails()) {
                return response()->json(['success' => false, 'message' => 'Invalid email address', 'errors' => $emailValidator->errors()]);
            }

            $data_email = [
                'subject' => $request->input('subject'),
                'sender_name' => 'bussinesyafiq@gmail.com',
                'isi' => $request->input('message'),
            ];

            // Kirim email
            if (is_array($emails)) {
                foreach ($emails as $email) {
                    Mail::to($email)->send(new KirimEmail($data_email));

                    // Update status in the Antrian table for the processed email
                    Antrian::where('email', $email)->update(['status' => 'selesai']);
                }
            }

            // Simpan data ke dalam tabel email_history
            foreach ($emails as $email) {
                EmailHistory::create([
                    'email' => trim($email),
                    'subject' => $request->input('subject'),
                    'message' => $request->input('message'),
                ]);
            }

            // Berhasil
            // Redirect to the /dashboard route with a success message and trigger SweetAlert
            return redirect('/dashboard')->with(['success' => 'Email berhasil terkirim']);
        } catch (\Exception $e) {
            // Error
            // Redirect back with an error message and trigger SweetAlert
            return redirect()->back()->with(['error' => 'Terjadi kesalahan saat mengirim email: ' . $e->getMessage()]);
        }
    }

    //    @push('scripts')
    // <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    // @endpush

    public function bantuan()
    {
        return view('Master.Bantuan');
    }
}
