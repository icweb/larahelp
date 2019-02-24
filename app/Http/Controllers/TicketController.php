<?php

namespace App\Http\Controllers;

use App\Events\TicketAssigned;
use App\Events\TicketClosed;
use App\Events\TicketCreated;
use App\Http\Requests\AssignsTickets;
use App\Http\Requests\ClosesTickets;
use App\Http\Requests\CreatesTickets;
use App\Ticket;
use App\TicketCategory;
use App\TicketPriority;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = isset($_GET['filter']) ? $_GET['filter'] : '';
        $tickets = Ticket::mine()->status($status)->get();

        return view('tickets.index', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = TicketCategory::all();
        $priorities = TicketPriority::all();

        return view('tickets.create', [
            'categories' => $categories,
            'priorities' => $priorities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatesTickets  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesTickets $request)
    {
        $ticket = auth()->user()->tickets()->create([
            'category_id'       => $request->input('category'),
            'priority_id'       => $request->input('priority'),
            'subject'           => $request->input('subject'),
            'body'              => $request->input('body'),
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $comments = $ticket
            ->comments()
            ->visible()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.show', [
            'ticket'    => $ticket,
            'comments'  => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assign(AssignsTickets $request, Ticket $ticket)
    {
        if($request->input('type') === 'assign')
        {
            $ticket->update([
                'agent_id' => auth()->id()
            ]);
        }
        else
        {
            $ticket->update([
                'agent_id' => null
            ]);
        }

        return redirect()->back();
    }

    public function close(ClosesTickets $request, Ticket $ticket)
    {
        $ticket->update(['closed_at' => time()]);

        return redirect()->back();
    }
}
