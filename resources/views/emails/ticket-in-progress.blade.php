<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket In Progress</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .info-badge {
            display: inline-block;
            background-color: #cfe2ff;
            color: #084298;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 2px solid #b6d4fe;
        }
        .ticket-info {
            background-color: #f8f9fa;
            border-left: 4px solid #0dcaf0;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .ticket-info h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 140px;
        }
        .info-value {
            color: #2c3e50;
            flex: 1;
        }
        .message-box {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .message-box h4 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .message-content {
            color: #495057;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            opacity: 0.9;
        }
        .progress-section {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .progress-section h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .progress-section p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #bdc3c7;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 30px 0;
        }
        .timeline {
            position: relative;
            padding-left: 30px;
            margin: 25px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background-color: #0dcaf0;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #0dcaf0;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #0dcaf0;
        }
        .timeline-item.completed::before {
            background-color: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }
        .timeline-item h5 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 600;
        }
        .timeline-item p {
            margin: 0;
            color: #6c757d;
            font-size: 13px;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">
             <img width="100" height="100" src="https://ithelpdesk.nlrlibrary.org/images/logo.png">
            </div>
        <h1 style="color: black;">Ticket In Progress</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <span class="info-badge">Status Updated: In Progress</span>
            
            <p style="font-size: 16px; color: #2c3e50; margin: 20px 0;">
                Hello <strong>{{ $ticket->from_name }}</strong>,
            </p>

            <p style="font-size: 16px; color: #495057; line-height: 1.6;">
                Good news! We have started working on your ticket. <strong>{{ $ticket->assigned_to }}</strong> is now working to resolve your issue.
            </p>

            <!-- Ticket Information -->
            <div class="ticket-info">
                <h3>Ticket Details</h3>
                <div class="info-row">
                    <div class="info-label">Ticket Number:</div>
                    <div class="info-value"><strong>{{ $ticket->ticket_number }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value">{{ $ticket->subject }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Assigned To:</div>
                    <div class="info-value">{{ $ticket->assigned_to }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value"><strong style="color: #0dcaf0;">In Progress</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submitted:</div>
                    <div class="info-value">{{ $ticket->received_time->format('F d, Y \a\t g:i A') }}</div>
                </div>
            </div>

            <!-- Timeline -->
            <h4 style="color: #2c3e50; margin-top: 30px;">Ticket Progress</h4>
            <div class="timeline">
                <div class="timeline-item completed">
                    <h5>Ticket Submitted</h5>
                    <p>{{ $ticket->received_time->format('M d, Y g:i A') }}</p>
                </div>
                <div class="timeline-item completed">
                    <h5>Assigned to {{ $ticket->assigned_to }}</h5>
                    <p>{{ $ticket->created_at->format('M d, Y g:i A') }}</p>
                </div>
                <div class="timeline-item completed">
                    <h5>Work Started</h5>
                    <p>{{ now()->format('M d, Y g:i A') }}</p>
                </div>
                <div class="timeline-item">
                    <h5>Resolution</h5>
                    <p>In progress...</p>
                </div>
            </div>

        <!-- Footer -->
        <div class="footer">
            <p style="font-weight: 600; font-size: 16px; color: #ffffff; margin-bottom: 10px;">
               NLRPLS IT Support Ticketing System
            </p>
            <p>North Little Rock Library System</p>
            <p>
                Need help? Contact us at 
                <a href="mailto:ithelpdesk@nlrlibrary.org">ithelpdesk@nlrlibrary.org</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} IT Support. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>