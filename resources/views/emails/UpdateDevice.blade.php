<!DOCTYPE html>
<html>
  <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
      <h2 style="color: #2c3e50; border-bottom: 2px solid #e74c3c; padding-bottom: 10px;">
        New Support Ticket Created
      </h2>
      
      <div style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
        <h3 style="margin-top: 0; color: #856404;">Ticket #{{ $ticket->id }}</h3>
        <p><strong>From:</strong> {{ $ticket->from_name }} ({{ $ticket->from_email }})</p>
        <p><strong>Department:</strong> {{ $ticket->department ?? 'N/A' }}</p>
        <p><strong>Office Location:</strong> {{ $ticket->office_location ?? 'N/A' }}</p>
        <p><strong>Assigned To:</strong> {{ $ticket->assigned_to }}</p>
        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
        <p><strong>Received:</strong> {{ $ticket->received_time ? $ticket->received_time->format('m/d/Y H:i') : 'N/A' }}</p>
      </div>
      
      <div style="background-color: #f8f9fa; padding: 15px; margin: 20px 0;">
        <h4 style="margin-top: 0;">Subject:</h4>
        <p style="font-size: 1.1em; color: #2c3e50;">{{ $ticket->subject }}</p>
        
        <h4>Message Preview:</h4>
        <p style="border-left: 3px solid #ccc; padding-left: 15px; color: #555;">
          {{ Str::limit(strip_tags($ticket->body), 200) }}
        </p>
      </div>
      
      <p style="margin-top: 30px; padding: 15px; background-color: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460;">
        <strong>Action Required:</strong> Please review and respond to this ticket.
      </p>
      
      <p style="font-size: 0.85em; color: #999; margin-top: 20px;">
        This is an automated notification from the IT Support Ticketing System at NLRPLS.
      </p>
    </div>
  </body>
</html>
