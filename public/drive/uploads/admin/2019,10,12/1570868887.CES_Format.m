clear; clc;

%% Import Aircraft and Airport
[num,text,cesreg] = xlsread('aircraftmu.csv','D2:D557');
[num,text,cshreg] = xlsread('aircraftfm.csv','D2:D104');

[num,text,airport] = xlsread('IATA ICAO.xlsx');
IATA = airport(:,1);
ICAO = airport(:,2);

%% Import Original File
fileName = input('Input file name: ','s');
[num, text, org] = xlsread(fileName);
org = org(2:end,1:end-1);

%% Remove Repeating Flights
orgSize = size(org,1);
index1 = 1;
while(index1<(orgSize-1))
    index2 = index1+1;
    while(index2<orgSize)
        if(org{index2,2}==org{index1,2}) % Same Flight Num
            if(org{index2,3}==org{index1,3}&org{index2,4}==org{index1,4}) % Same dep and arr
                if(org{index2,5}==org{index1,5}) % Same time
                    org(index2,:)=[];
                    orgSize = orgSize-1;
                end
            end
        end
        index2 = index2+1;
    end
    index1 = index1+1;
end

%% Assign to Attributes
airline = org(:,1);
fltNum = org(:,2);
origin = org(:,3);
dest = org(:,4);
dep = org(:,5);
arr = org(:,6);
days = org(:,7);
time = org(:,8);
dis = org(:,9);
equip = org(:,11);

%% Format Airline
for(i = 1:length(airline))
    if(airline{i}=='FM')
        airline{i}='CSH';
    elseif(airline{i}=='MU')
        airline{i}='CES';
    elseif(airline{i}=='KN')
        airline{i}='CUA';
    end
end

%% Format Flight Number
append = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
for(index1=1:(length(fltNum)-1))
    a = 1;
    if(~ischar(fltNum{index1}))
        for(index2=(index1+1):length(fltNum))
            if(isequal(fltNum{index2},fltNum{index1}))
                fltNum{index2} = [int2str(fltNum{index2}),append(a)];
                a = a+1;
            end
        end
    end
end

%% Format Airports
% Departure
for(ind=1:length(origin))
    index=1;
    found = false;
    while(index<=length(IATA) && ~found)
        if(strcmpi(origin{ind},IATA{index}))
            found = true;
            origin{ind} = ICAO{index};
        end
        index = index+1;
    end
    if(~found)
        fprintf('Error replacing %s.\n',origin{ind});
    end
end
% Arrival
for(ind=1:length(dest))
    index=1;
    found = false;
    while(index<=length(IATA) && ~found)
        if(strcmpi(dest{ind},IATA{index}))
            found = true;
            dest{ind} = ICAO{index};
        end
        index = index+1;
    end
    if(~found)
        fprintf('Error replacing %s.\n',dest{ind});
    end
end

%% Format Time
% Dep
for(ind=1:length(dep))
    dep{ind} = int2str(dep{ind});
    dep{ind} = [dep{ind}(1,end-2),':',dep{ind}(end-1,end)];
end
% Arr
for(ind=1:length(arr))
    arr{ind} = int2str(arr{ind});
    arr{ind} = [arr{ind}(1,end-2),':',arr{ind{(end-1,end)];
end

%% Format Aircraft Registration


% Check Codeshare
        


